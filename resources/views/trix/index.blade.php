@extends('layouts.app')

@section('content')
    <style>
        * {
            box-sizing: border-box;
        }

        .custom-modal {
            position: absolute;
            /* Stay in place */
            z-index: 1000;
            /* Sit on top */
            /*padding-top: 100px;*/
            /* Location of the box */
            left: 50%;
            top: 30%;
            width: 200px;
            /* Full width */
            height: 300px;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(247, 247, 247);
            /* Fallback color */
            /*background-color: rgba(255, 255, 255, 0.4);*/
            box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
        }

        #myInput {
            background-position: 10px 10px;
            background-repeat: no-repeat;
            width: 100%;
            font-size: 16px;
            padding: 12px 20px 12px 40px;
            border: 1px solid #ddd;
            margin-bottom: 12px;
        }

        #myTable {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ddd;
            font-size: 18px;
        }

        #myTable th,
        #myTable td {
            text-align: left;
            padding: 12px;
        }

        #myTable td a {
            display: block;
        }

        #myTable tr {
            border-bottom: 1px solid #ddd;
        }

        #myTable tr.header,
        #myTable tr:hover {
            background-color: #f1f1f1;
        }
    </style>
    <div class="container">
        <form method="POST" action="{{ route('post.store') }}">
            @csrf
            <div>
                <label for="title">Title
                    <input name="title" type="text" class="form-control mb-4" placeholder="Title!">
                </label>
                <input id="x" type="hidden" name="content">
                <trix-editor input="x" id="trix-editor"></trix-editor>
            </div>
            <div>
                <input id="submit" class="btn btn-info mt-2" type="submit">
            </div>
        </form>
        <div class="custom-modal" id="custom-modal" style="display: none">
            <table id="myTable">
                <tr>
                    <td id="bold"><a onclick="imHere(this)">bold</a></td>
                </tr>
                <tr>
                    <td><a onclick="imHere(this)">italic</a></td>
                </tr>
                <tr>
                    <td><a onclick="imHere(this)">strike</a></td>
                </tr>
                <tr>
                    <td><a onclick="imHere(this)">href</a></td>
                </tr>
                <tr>
                    <td><a onclick="imHere(this)">heading1</a></td>
                </tr>
                <tr>
                    <td><a onclick="imHere(this)">quote</a></td>
                </tr>
                <tr>
                    <td><a onclick="imHere(this)">code</a></td>
                </tr>
                <tr>
                    <td><a onclick="imHere(this)">bullet</a></td>
                </tr>
                <tr>
                    <td><a onclick="imHere(this)">number</a></td>
                </tr>
                <tr>
                    <td><a onclick="imHere(this)">attachFiles</a></td>
                </tr>
            </table>
        </div>
    </div>

    <script>
        let element = document.querySelector('trix-editor');
        let pop_up = document.getElementById("custom-modal");

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

            pop_up.style.display = "none";

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
            // popup absolute view
            let carret_range = element.editor.getClientRectAtPosition(element.editor.getSelectedRange()[0]);
            console.log(carret_range.left, carret_range.top);
            pop_up.style.left = (10 + carret_range.left) + "px";
            pop_up.style.top = (10 + carret_range.top) + "px";
            pop_up.style.display = "";
            console.log('triggered');
        }

        element.addEventListener('keyup', (event) => {

            //13 enter, 32 space, 191 slash, 8 backspace

            // console.log(element.editor.getClientRectAtPosition(1));

            let value = element.textContent;
            previous_key = present_key;
            present_key = event.keyCode;

            // if / is triggered
            if (trigger) {
                let last_index = element.innerText.lastIndexOf('/');
                // popup absolute view
                let carret_range = element.editor.getClientRectAtPosition(element.editor.getSelectedRange()[0]);
                console.log(carret_range.left, carret_range.top);
                pop_up.style.left = (10 + carret_range.left) + "px";
                pop_up.style.top = (10 + carret_range.top) + "px";
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
