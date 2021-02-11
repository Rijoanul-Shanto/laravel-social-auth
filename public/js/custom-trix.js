window.onload = () => {
    let element = document.querySelector('trix-editor');
    // console.log(element);

    let new_line = true;
    let previous_key = null;
    let present_key = null;
    var trigger = false;
    var temp = "";

    // reset table
    let resetTable = () => {
        let i = 0;
        let table = document.getElementById("myTable");
        let tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            tr[i].style.display = "";
        }
    }
    // toggle attribute
    let imHere = (al) => {
        resetTable();

        let text_content = element.innerText;
        let last_index_slash = text_content.lastIndexOf("/");
        let last_index_carriage = text_content.lastIndexOf("\n");

        // if attribute is active then toggle to deactive
        if (element.editor.attributeIsActive(al.text)) {
            element.editor.setSelectedRange([last_index_slash, text_content.length + 1]);
            element.editor.deleteInDirection("backward");

            element.editor.deactivateAttribute(al.text);
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
            element.editor.activateAttribute(al.text);
        }
    }

    // Search elements
    let myFunction = (input) => {
        let filter, table, tr, td, i;
        filter = input.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    let runScript = () => {
        console.log('triggered');
    }

    element.addEventListener('keyup', (event) => {

        //13 enter, 32 space, 191 slash, 8 backspace

        let value = element.textContent;
        previous_key = present_key;
        present_key = event.keyCode;

        // if / is triggered
        if (trigger) {
            let last_index = element.innerText.lastIndexOf('/');
            // console.log(last_index);
            myFunction(element.innerText.slice(last_index + 1));
        }
        // if previous key is enter or space and present key is /
        if ((previous_key === null && present_key === 191) || (previous_key === 13 && present_key === 191)) {
            trigger = true;
            runScript();
        }
        // if present key is /
        else if (present_key === 191) {
            console.log("present key pressed");
            let element_string = element.innerText;
            let last_index = element_string.lastIndexOf('\n');
            let final_str = element_string.substring(last_index, element_string.length - 1);
            if (final_str.length === 1) {
                trigger = true;
                runScript();
            }
        }
        // if present key is enter or space
        else if (present_key === 13 || present_key === 32) {
            resetTable();
            trigger = false;
        }
        // if document is empty
        if (value.length === 0) {
            previous_key = null;
            present_key = null;
        }
    });

}
