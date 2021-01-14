let element = document.querySelector('trix-editor');
let pop_up = document.getElementById("custom-modal");

let new_line = true;
let previous_key = null;
let present_key = null;
let trigger = false;
let popup_handle_up = false;
let popup_handle_down = false;
let pop_up_toggled = false;

Trix.config.blockAttributes.heading2 = {terminal: true, breakOnReturn: true, group: false, tagName: 'h2'};

addEventListener("trix-attachment-add", function (event) {
    if (event.attachment.file) {
        // uploadFileAttachment(event.attachment);
        console.log(event.attachment.file)
    }
})
// reset table
let resetTable = () => {
    let i = 0;
    let item_list = document.getElementById("itemList");
    let item = item_list.getElementsByTagName("li");
    for (i = 0; i < item.length; i++) {
        item[i].style.display = "";
        item[i].classList.remove("selected");
        item[i].classList.remove("focused");
        item[i].classList.add("not-selected");
    }
}

let linkProcess = () => {
    let data = "";
    let link_value = document.getElementById("link-modal").getElementsByTagName("input");
    console.log(link_value[0].value);

    element.focus();

    if (link_value) {
        let link_modal = document.getElementById("link-modal");
        link_modal.style.display = "none";
        let link_range = element.editor.getSelectedRange();
        element.editor.setSelectedRange(link_range);
        element.editor.activateAttribute("href", link_value[0].value);
    }
}

let embedProcess = () => {
    let data = "";
    let embed_value = document.getElementById("embed-modal").getElementsByTagName("input");
    // console.log(embed_value[0].value);

    element.focus();

    if (embed_value) {
        let embed_modal = document.getElementById("embed-modal");
        embed_modal.style.display = "none";
        let regex_sld = RegExp('(?:[-a-zA-Z0-9@:%_\\+~.#=]{2,256}\\.)?([-a-zA-Z0-9@:%_\\+~#=]*)\\.[a-z]{2,6}\\b(?:[-a-zA-Z0-9@:%_\+.~#?&\\/\\/=]*)', 'i');
        let regex_match = embed_value[0].value.toString();

        let regex_res = regex_sld.exec(regex_match)[1];

        if ("youtube" === regex_res || "youtu" === regex_res) {
            let regex_id = RegExp('^.*(youtu.be\\/|v\\/|u\\/\\w\\/|embed\\/|watch\\?v=|\\&v=)([^#\\&\\?]*).*');
            const youtube_id = regex_id.exec(regex_match)[2];

            const iframe_markup = '<iframe width="560" height="340" frameborder="0" src="http://www.youtube.com/embed/' + youtube_id + '" allowfullscreen></iframe>';

            let embed_range = element.editor.getSelectedRange();
            element.editor.setSelectedRange(embed_range);

            let attachment = new Trix.Attachment({content: iframe_markup});
            element.editor.insertAttachment(attachment)
        } else if ("facebook" === regex_res || "fb" === regex_res) {

        }
    }
}

// toggle attribute
let toggleTrixAttribute = (list_element) => {
    resetTable();
    let list_element_type = list_element.id.trim();
    pop_up.style.display = "none";

    let text_content = element.innerText;
    let last_index_slash = text_content.lastIndexOf("/");
    let last_index_carriage = text_content.lastIndexOf("\n");

    // if attribute is active then toggle to deactivate
    if (element.editor.attributeIsActive(list_element_type)) {
        element.editor.setSelectedRange([last_index_slash, text_content.length + 1]);
        element.editor.deleteInDirection("backward");

        element.editor.deactivateAttribute(list_element_type);
    }
    // if attribute is not active
    else {
        // avoid deleting previous tags
        if (last_index_slash < 0 || last_index_carriage > last_index_slash) {
            return;
        }
        // delete search query string
        if (text_content[text_content.length] !== 13) {
            element.editor.setSelectedRange([last_index_slash, text_content.length + 1]);
            element.editor.deleteInDirection("backward");
        }
        if (list_element_type !== "href") element.editor.activateAttribute(list_element_type);
    }

    if (list_element_type === "href") {
        let link_process = document.getElementById("link-modal");
        link_process.style.display = "block";
        link_process.getElementsByTagName("input")[0].focus();

        link_process.getElementsByTagName("input")[0].addEventListener("keyup", (event) => {
            event.keyCode === 13 ? linkProcess() : "";
            27 === event.keyCode ? (link_process.style.display = "none", element.focus()) : "";
        });
    } else if (list_element_type === "embed") {
        let embed_process = document.getElementById("embed-modal");
        embed_process.style.display = "block";
        embed_process.getElementsByTagName("input")[0].focus();

        embed_process.getElementsByTagName("input")[0].addEventListener("keyup", (event) => {
            event.keyCode === 13 ? embedProcess() : "";
            27 === event.keyCode ? (embed_process.style.display = "none", element.focus()) : "";
        });
    }
}

// Search elements
let searchElement = (input) => {
    let filter, i;
    filter = input.toUpperCase();
    let item_list = document.getElementById("itemList");
    let item = item_list.getElementsByTagName("li");
    for (i = 0; i < item.length; i++) {
        if (item[i]) {
            if (item[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
                item[i].style.display = "";
                item[i].classList.remove("not-selected");
                item[i].classList.add("selected");
            } else {
                item[i].style.display = "none";
                item[i].classList.remove("selected");
                item[i].classList.add("not-selected");
            }
        }
    }
}

let runScript = () => {
    // popup absolute view
    let carret_range = element.editor.getClientRectAtPosition(element.editor.getSelectedRange()[0]);
    pop_up.style.left = (10 + carret_range.left) + "px";
    pop_up.style.top = (10 + carret_range.top) + "px";
    pop_up.style.display = "";
}

// Handle Enter key press on selected item
let handleKeyPress = () => {
    let i = 0;
    let item_list = document.getElementById("itemList");
    let item = item_list.getElementsByTagName("li");
    for (i = 0; i < item.length; i++) {
        if (item[i].className === "selected focused") {
            return item[i];
        }
    }
}

window.addEventListener("keyup", (event) => {
    if (pop_up_toggled) {
        let item_list = document.getElementById("itemList");
        let li_items = item_list.getElementsByTagName("li");
        let li_items_length = li_items.length;
        let i = 0, j = 0;

        if (event.keyCode === 27) {
            resetTable();
            pop_up.style.display = "none";
            trigger = false;
            pop_up_toggled = false;
            popup_handle_down = false;
        } else if (event.keyCode == 13) {
            let selected_item = handleKeyPress();
            if (selected_item) toggleTrixAttribute(selected_item);
            else {
                resetTable();
                pop_up.style.display = "none";
            }
            trigger = false;
            pop_up_toggled = false;
            popup_handle_down = false;
        } else if (event.keyCode === 40) {
            if (popup_handle_down) {
                for (i = 0; i < li_items_length; i++) {
                    if (li_items[i].className === "selected focused") {
                        break;
                    }
                }
                for (j = i + 1; j < li_items_length; j++) {
                    if (li_items[j].className === "selected") {
                        li_items[i].classList.remove("focused");
                        li_items[j].classList.add("focused");
                        li_items[j].focus();
                        break;
                    }
                }
            } else {
                for (i = 0; i < li_items_length; i++) {
                    if (li_items[i].className === "selected") {
                        li_items[i].classList.add("focused");
                        li_items[i].focus();
                        popup_handle_down = true;
                        break;
                    }
                }
            }
        } else if (event.keyCode === 38) {
            for (i = li_items_length - 1; i >= 0; i--) {
                if (li_items[i].className === "selected focused") {
                    break;
                }

            }
            for (j = i - 1; j >= 0; j--) {
                if (li_items[j].className === "selected") {
                    li_items[i].classList.remove("focused");
                    li_items[j].classList.add("focused");
                    li_items[j].focus();
                    break;
                }
            }
        }
    }
});

element.addEventListener('keyup', (event) => {
    //13 enter, 32 space, 191 slash, 8 backspace

    let value = element.innerText;
    previous_key = present_key;
    present_key = event.keyCode;

    // if / is triggered
    if (trigger) {
        if (event.keyCode === 40 || event.keyCode === 13) pop_up_toggled = true;

        let last_index = element.innerText.lastIndexOf('/');
        let last_carriage = element.innerText.lastIndexOf('\n');

        if (last_carriage > last_index) {
            pop_up.style.display = "none";
            trigger = false;
        }

        // popup absolute view
        let carret_range = element.editor.getClientRectAtPosition(element.editor.getSelectedRange()[0]);
        if (carret_range !== undefined) {
            pop_up.style.left = (10 + carret_range.left) + "px";
            pop_up.style.top = (10 + carret_range.top) + "px";
        }
        searchElement(element.innerText.slice(last_index + 1));
    }
    // if previous key is enter or space and present key is /
    if ((previous_key === null && present_key === 191) || (previous_key === 13 && present_key === 191)) {
        trigger = true;
        runScript();
    }
    // if present key is /
    else if (present_key === 191) {
        console.log("pressed");
        let element_string = element.innerText;
        let last_index = element_string.lastIndexOf('\n');
        let final_str = element_string.substring(last_index, element_string.length - 1);
        console.log(final_str.length);
        if (final_str.length === 1 || final_str.length === 0) {
            resetTable();
            trigger = true;
            runScript();
        }
    }
    // if present key is enter or space
    else if (present_key === 13 || present_key === 32 || present_key === 27) {
        resetTable();
        pop_up.style.display = "none";
        trigger = false;
    }
    // if document is empty
    if (value.length === 0) {
        pop_up.style.display = "none";
        previous_key = null;
        present_key = null;
    }
});
