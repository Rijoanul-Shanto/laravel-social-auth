@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('post.store') }}">
            @csrf
            <div>
                <input type="file" name="file">
                <input id="title" name="title" type="text" class="form-control mb-4" placeholder="Title">
                <input id="x" type="hidden" name="content">
                <trix-editor input="x" id="trix-editor"></trix-editor>
            </div>
            <div>
                <input id="submit" class="btn btn-info mt-2" type="submit">
            </div>
        </form>
        <div class="custom-modal" id="custom-modal" style="display: none">
            <ul id="itemList">
                <li tabindex="-1" class="not-selected"><a onclick="imHere(this)" onkeypress="alert('hello')">bold</a>
                </li>
                <li tabindex="-1" class="not-selected"><a onclick="imHere(this)">italic</a></li>
                <li tabindex="-1" class="not-selected"><a onclick="imHere(this)">strike</a></li>
                <li tabindex="-1" class="not-selected"><a onclick="imHere(this)">href</a></li>
                <li tabindex="-1" class="not-selected"><a onclick="imHere(this)">heading1</a></li>
                <li tabindex="-1" class="not-selected"><a onclick="imHere(this)">quote</a></li>
                <li tabindex="-1" class="not-selected"><a onclick="imHere(this)">code</a></li>
                <li tabindex="-1" class="not-selected"><a onclick="imHere(this)">bullet</a></li>
                <li tabindex="-1" class="not-selected"><a onclick="imHere(this)">number</a></li>
                <li tabindex="-1" class="not-selected"><a onclick="imHere(this)">attachFiles</a></li>
            </ul>
        </div>
    </div>

    <script>
        let element = document.querySelector('trix-editor');
        let pop_up = document.getElementById("custom-modal");

        let new_line = true;
        let previous_key = null;
        let present_key = null;
        let trigger = false;
        let temp = "";
        let popup_handle_up = false;
        let popup_handle_down = false;
        let pop_up_toggled = false;

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

        // toggle attribute
        let imHere = (al) => {
            resetTable();

            al.textContent = al.textContent.trim();

            pop_up.style.display = "none";

            let text_content = element.innerText;
            let last_index_slash = text_content.lastIndexOf("/");
            let last_index_carriage = text_content.lastIndexOf("\n");

            // if attribute is active then toggle to deactive
            if (element.editor.attributeIsActive(al.textContent)) {
                element.editor.setSelectedRange([last_index_slash, text_content.length + 1]);
                element.editor.deleteInDirection("backward");

                element.editor.deactivateAttribute(al.textContent);
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
                element.editor.activateAttribute(al.textContent);
            }
        }

        // Search elements
        let myFunction = (input) => {
            let filter, table, tr, td, i;
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
            console.log(carret_range.left, carret_range.top);
            pop_up.style.left = (10 + carret_range.left) + "px";
            pop_up.style.top = (10 + carret_range.top) + "px";
            pop_up.style.display = "";
            // console.log('triggered');
        }

        // Handle Enter key press on selected item
        let handleKeyPress = () => {
            console.log("item");
            let i = 0;
            let item_list = document.getElementById("itemList");
            let item = item_list.getElementsByTagName("li");
            for (i = 0; i < item.length; i++) {
                console.log(item[i].textContent);
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
                console.log(popup_handle_down);

                if (event.keyCode === 27) {
                    resetTable();
                    pop_up.style.display = "none";
                    trigger = false;
                    pop_up_toggled = false;
                    popup_handle_down = false;
                } else if (event.keyCode == 13) {
                    let selected_item = handleKeyPress();
                    console.log("table reset...", selected_item.textContent.trim());
                    if (selected_item !== undefined) imHere(selected_item);
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
                            // console.log(li_items[i].previousElementSibling);
                            if (li_items[i].className === "selected focused") {
                                // console.log("found");
                                break;
                            }
                        }
                        for (j = i + 1; j < li_items_length; j++) {
                            // console.log("down elements", li_items);
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
                        // console.log(li_items[i].previousElementSibling);
                        if (li_items[i].className === "selected focused") {
                            // console.log("found from bottom", li_items[i]);
                            break;
                        }

                    }
                    for (j = i - 1; j >= 0; j--) {
                        // console.log("up elements", i);
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

        let handleArrow = (pressed_key) => {
            console.log("key pressed handle", pressed_key);
            pop_up_toggled = true;
            console.log(pop_up_toggled);
            // document.getElementById("itemList").getElementsByTagName("li")[0].focus();
        };

        element.addEventListener('keyup', (event) => {
            //13 enter, 32 space, 191 slash, 8 backspace

            // console.log(element.editor.getClientRectAtPosition(1));

            let value = element.innerText;
            previous_key = present_key;
            present_key = event.keyCode;

            // if / is triggered
            if (trigger) {
                console.log(event.keyCode);

                if (event.keyCode === 40 || event.keyCode === 13) {

                    handleArrow(event.keyCode);
                }
                let last_index = element.innerText.lastIndexOf('/');
                let last_carriage = element.innerText.lastIndexOf('\n');

                if (last_carriage > last_index) {
                    console.log("lost");
                    pop_up.style.display = "none";
                    trigger = false;
                }

                // console.log(last_index, last_carriage);
                // popup absolute view
                let carret_range = element.editor.getClientRectAtPosition(element.editor.getSelectedRange()[0]);
                if (carret_range !== undefined) {
                    // console.log(carret_range.left, carret_range.top);
                    pop_up.style.left = (10 + carret_range.left) + "px";
                    pop_up.style.top = (10 + carret_range.top) + "px";
                }
                myFunction(element.innerText.slice(last_index + 1));
            }
            // if previous key is enter or space and present key is /
            if ((previous_key === null && present_key === 191) || (previous_key === 13 && present_key === 191)) {
                trigger = true;
                runScript();
            }
            // if present key is /
            else if (present_key === 191) {
                // console.log("present key pressed");
                let element_string = element.innerText;
                let last_index = element_string.lastIndexOf('\n');
                let final_str = element_string.substring(last_index, element_string.length - 1);
                if (final_str.length === 1) {
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
    </script>
@endsection
