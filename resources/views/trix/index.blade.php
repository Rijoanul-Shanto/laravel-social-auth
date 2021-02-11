@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('post.store') }}">
            @csrf
            <div>
                <input id="title" name="title" type="text" class="form-control mb-4" placeholder="Title">
                <input id="x" type="hidden" name="content">
                <trix-editor input="x" id="trix-editor" class="trix-content"></trix-editor>
            </div>
            <div>
                <input id="submit" class="btn btn-info mt-2" type="submit">
            </div>
        </form>
        <div class="custom-modal" id="custom-modal"
             style="display: none; border: 1px solid #ededed; border-radius: .4rem;">
            <ul class="itemList" id="itemList" style="list-style-type: none; padding-left: 0">
                <div class="trix_subsection">Basic</div>
                <li tabindex="-1" id="href" class="not-selected">
                    <div class="li-item" style="padding: .75rem; margin-bottom: 0; display: inline-flex; width: 100%;">
                        <div class="icon-preview">
                            <svg width="20" height="26" viewBox="0 0 20 26" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M0 0H6.41485V1.06838H5.42198C4.805 1.06838 4.30484 1.56854 4.30484 2.18551V6.42305H10.7187V2.18551C10.7187 1.56854 10.2185 1.06838 9.60157 1.06838H8.58509V0H15V1.06838H13.9945C13.3775 1.06838 12.8774 1.56854 12.8774 2.18551V12.8037C12.8774 13.4206 13.3775 13.9208 13.9945 13.9208H15V15H8.58509V13.9208H9.60157C10.2185 13.9208 10.7187 13.4206 10.7187 12.8037V7.5H4.30484V12.8037C4.30484 13.4206 4.805 13.9208 5.42198 13.9208H6.41485V15H0V13.9208H1.031C1.64798 13.9208 2.14814 13.4206 2.14814 12.8037V2.18552C2.14814 1.56854 1.64798 1.06838 1.031 1.06838H0V0ZM19.1 19.5C19.5971 19.5 20 19.9029 20 20.4C20 20.8971 19.5971 21.3 19.1 21.3H0.899999C0.402943 21.3 0 20.8971 0 20.4C0 19.9029 0.402944 19.5 0.9 19.5H19.1ZM17 24.9C17 24.4029 16.5971 24 16.1 24H0.9C0.402944 24 0 24.4029 0 24.9C0 25.3971 0.402943 25.8 0.899999 25.8H16.1C16.5971 25.8 17 25.3971 17 24.9Z"
                                      fill="#8D9CAE"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M16 14.1774H16.37C16.6351 14.1774 16.85 13.9625 16.85 13.6974V10.835C16.85 10.5699 16.6351 10.355 16.37 10.355H16.0171V9.5L18.185 9.5V13.6974C18.185 13.9625 18.3999 14.1774 18.665 14.1774H19V15H16V14.1774Z"
                                      fill="#8D9CAE"></path>
                            </svg>
                        </div>
                        <div style="flex: 3 1;margin-left: .85rem;">
                            <div class="dropdown-title">href</div>
                            <div class="dropdown-subtitle">Medium section heading</div>
                        </div>
                    </div>
                    <a onclick="toggleTrixAttribute(this.parentNode)"></a>
                </li>
                <li tabindex="-1" id="embed" class="not-selected">
                    <div style="padding: .75rem; margin-bottom: 0; display: inline-flex; width: 100%;">
                        <div class="icon-preview">
                            <svg width="20" height="26" viewBox="0 0 20 26" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M0 0H6.41485V1.06838H5.42198C4.805 1.06838 4.30484 1.56854 4.30484 2.18551V6.42305H10.7187V2.18551C10.7187 1.56854 10.2185 1.06838 9.60157 1.06838H8.58509V0H15V1.06838H13.9945C13.3775 1.06838 12.8774 1.56854 12.8774 2.18551V12.8037C12.8774 13.4206 13.3775 13.9208 13.9945 13.9208H15V15H8.58509V13.9208H9.60157C10.2185 13.9208 10.7187 13.4206 10.7187 12.8037V7.5H4.30484V12.8037C4.30484 13.4206 4.805 13.9208 5.42198 13.9208H6.41485V15H0V13.9208H1.031C1.64798 13.9208 2.14814 13.4206 2.14814 12.8037V2.18552C2.14814 1.56854 1.64798 1.06838 1.031 1.06838H0V0ZM19.1 19.5C19.5971 19.5 20 19.9029 20 20.4C20 20.8971 19.5971 21.3 19.1 21.3H0.899999C0.402943 21.3 0 20.8971 0 20.4C0 19.9029 0.402944 19.5 0.9 19.5H19.1ZM17 24.9C17 24.4029 16.5971 24 16.1 24H0.9C0.402944 24 0 24.4029 0 24.9C0 25.3971 0.402943 25.8 0.899999 25.8H16.1C16.5971 25.8 17 25.3971 17 24.9Z"
                                      fill="#8D9CAE"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M16 14.1774H16.37C16.6351 14.1774 16.85 13.9625 16.85 13.6974V10.835C16.85 10.5699 16.6351 10.355 16.37 10.355H16.0171V9.5L18.185 9.5V13.6974C18.185 13.9625 18.3999 14.1774 18.665 14.1774H19V15H16V14.1774Z"
                                      fill="#8D9CAE"></path>
                            </svg>
                        </div>
                        <div style="flex: 3 1;margin-left: .85rem;">
                            <div class="dropdown-title">embed</div>
                            <div class="dropdown-subtitle">Medium section heading</div>
                        </div>
                    </div>
                    <a onclick="toggleTrixAttribute(this.parentNode)"></a>
                </li>
                <li tabindex="-1" id="heading1" class="not-selected">
                    <div style="padding: .75rem; margin-bottom: 0; display: inline-flex; width: 100%;">
                        <div class="icon-preview">
                            <svg width="20" height="26" viewBox="0 0 20 26" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M0 0H6.41485V1.06838H5.42198C4.805 1.06838 4.30484 1.56854 4.30484 2.18551V6.42305H10.7187V2.18551C10.7187 1.56854 10.2185 1.06838 9.60157 1.06838H8.58509V0H15V1.06838H13.9945C13.3775 1.06838 12.8774 1.56854 12.8774 2.18551V12.8037C12.8774 13.4206 13.3775 13.9208 13.9945 13.9208H15V15H8.58509V13.9208H9.60157C10.2185 13.9208 10.7187 13.4206 10.7187 12.8037V7.5H4.30484V12.8037C4.30484 13.4206 4.805 13.9208 5.42198 13.9208H6.41485V15H0V13.9208H1.031C1.64798 13.9208 2.14814 13.4206 2.14814 12.8037V2.18552C2.14814 1.56854 1.64798 1.06838 1.031 1.06838H0V0ZM19.1 19.5C19.5971 19.5 20 19.9029 20 20.4C20 20.8971 19.5971 21.3 19.1 21.3H0.899999C0.402943 21.3 0 20.8971 0 20.4C0 19.9029 0.402944 19.5 0.9 19.5H19.1ZM17 24.9C17 24.4029 16.5971 24 16.1 24H0.9C0.402944 24 0 24.4029 0 24.9C0 25.3971 0.402943 25.8 0.899999 25.8H16.1C16.5971 25.8 17 25.3971 17 24.9Z"
                                      fill="#8D9CAE"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M16 14.1774H16.37C16.6351 14.1774 16.85 13.9625 16.85 13.6974V10.835C16.85 10.5699 16.6351 10.355 16.37 10.355H16.0171V9.5L18.185 9.5V13.6974C18.185 13.9625 18.3999 14.1774 18.665 14.1774H19V15H16V14.1774Z"
                                      fill="#8D9CAE"></path>
                            </svg>
                        </div>
                        <div style="flex: 3 1;margin-left: .85rem;">
                            <div class="dropdown-title">heading1</div>
                            <div class="dropdown-subtitle">Medium section heading</div>
                        </div>
                    </div>
                    <a onclick="toggleTrixAttribute(this.parentNode)"></a>
                </li>
                <li tabindex="-1" id="quote" class="not-selected">
                    <div style="padding: .75rem; margin-bottom: 0; display: inline-flex; width: 100%;">
                        <div class="icon-preview">
                            <svg width="20" height="26" viewBox="0 0 20 26" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M0 0H6.41485V1.06838H5.42198C4.805 1.06838 4.30484 1.56854 4.30484 2.18551V6.42305H10.7187V2.18551C10.7187 1.56854 10.2185 1.06838 9.60157 1.06838H8.58509V0H15V1.06838H13.9945C13.3775 1.06838 12.8774 1.56854 12.8774 2.18551V12.8037C12.8774 13.4206 13.3775 13.9208 13.9945 13.9208H15V15H8.58509V13.9208H9.60157C10.2185 13.9208 10.7187 13.4206 10.7187 12.8037V7.5H4.30484V12.8037C4.30484 13.4206 4.805 13.9208 5.42198 13.9208H6.41485V15H0V13.9208H1.031C1.64798 13.9208 2.14814 13.4206 2.14814 12.8037V2.18552C2.14814 1.56854 1.64798 1.06838 1.031 1.06838H0V0ZM19.1 19.5C19.5971 19.5 20 19.9029 20 20.4C20 20.8971 19.5971 21.3 19.1 21.3H0.899999C0.402943 21.3 0 20.8971 0 20.4C0 19.9029 0.402944 19.5 0.9 19.5H19.1ZM17 24.9C17 24.4029 16.5971 24 16.1 24H0.9C0.402944 24 0 24.4029 0 24.9C0 25.3971 0.402943 25.8 0.899999 25.8H16.1C16.5971 25.8 17 25.3971 17 24.9Z"
                                      fill="#8D9CAE"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M16 14.1774H16.37C16.6351 14.1774 16.85 13.9625 16.85 13.6974V10.835C16.85 10.5699 16.6351 10.355 16.37 10.355H16.0171V9.5L18.185 9.5V13.6974C18.185 13.9625 18.3999 14.1774 18.665 14.1774H19V15H16V14.1774Z"
                                      fill="#8D9CAE"></path>
                            </svg>
                        </div>
                        <div style="flex: 3 1;margin-left: .85rem;">
                            <div class="dropdown-title">quote</div>
                            <div class="dropdown-subtitle">Medium section heading</div>
                        </div>
                    </div>
                    <a onclick="toggleTrixAttribute(this.parentNode)"></a>
                </li>
                <li tabindex="-1" id="code" class="not-selected">
                    <div style="padding: .75rem; margin-bottom: 0; display: inline-flex; width: 100%;">
                        <div class="icon-preview">
                            <svg width="20" height="26" viewBox="0 0 20 26" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M0 0H6.41485V1.06838H5.42198C4.805 1.06838 4.30484 1.56854 4.30484 2.18551V6.42305H10.7187V2.18551C10.7187 1.56854 10.2185 1.06838 9.60157 1.06838H8.58509V0H15V1.06838H13.9945C13.3775 1.06838 12.8774 1.56854 12.8774 2.18551V12.8037C12.8774 13.4206 13.3775 13.9208 13.9945 13.9208H15V15H8.58509V13.9208H9.60157C10.2185 13.9208 10.7187 13.4206 10.7187 12.8037V7.5H4.30484V12.8037C4.30484 13.4206 4.805 13.9208 5.42198 13.9208H6.41485V15H0V13.9208H1.031C1.64798 13.9208 2.14814 13.4206 2.14814 12.8037V2.18552C2.14814 1.56854 1.64798 1.06838 1.031 1.06838H0V0ZM19.1 19.5C19.5971 19.5 20 19.9029 20 20.4C20 20.8971 19.5971 21.3 19.1 21.3H0.899999C0.402943 21.3 0 20.8971 0 20.4C0 19.9029 0.402944 19.5 0.9 19.5H19.1ZM17 24.9C17 24.4029 16.5971 24 16.1 24H0.9C0.402944 24 0 24.4029 0 24.9C0 25.3971 0.402943 25.8 0.899999 25.8H16.1C16.5971 25.8 17 25.3971 17 24.9Z"
                                      fill="#8D9CAE"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M16 14.1774H16.37C16.6351 14.1774 16.85 13.9625 16.85 13.6974V10.835C16.85 10.5699 16.6351 10.355 16.37 10.355H16.0171V9.5L18.185 9.5V13.6974C18.185 13.9625 18.3999 14.1774 18.665 14.1774H19V15H16V14.1774Z"
                                      fill="#8D9CAE"></path>
                            </svg>
                        </div>
                        <div style="flex: 3 1;margin-left: .85rem;">
                            <div class="dropdown-title">code</div>
                            <div class="dropdown-subtitle">Medium section heading</div>
                        </div>
                    </div>
                    <a onclick="toggleTrixAttribute(this.parentNode)"></a>
                </li>
                <li tabindex="-1" id="bullet" class="not-selected">
                    <div style="padding: .75rem; margin-bottom: 0; display: inline-flex; width: 100%;">
                        <div class="icon-preview">
                            <svg width="20" height="26" viewBox="0 0 20 26" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M0 0H6.41485V1.06838H5.42198C4.805 1.06838 4.30484 1.56854 4.30484 2.18551V6.42305H10.7187V2.18551C10.7187 1.56854 10.2185 1.06838 9.60157 1.06838H8.58509V0H15V1.06838H13.9945C13.3775 1.06838 12.8774 1.56854 12.8774 2.18551V12.8037C12.8774 13.4206 13.3775 13.9208 13.9945 13.9208H15V15H8.58509V13.9208H9.60157C10.2185 13.9208 10.7187 13.4206 10.7187 12.8037V7.5H4.30484V12.8037C4.30484 13.4206 4.805 13.9208 5.42198 13.9208H6.41485V15H0V13.9208H1.031C1.64798 13.9208 2.14814 13.4206 2.14814 12.8037V2.18552C2.14814 1.56854 1.64798 1.06838 1.031 1.06838H0V0ZM19.1 19.5C19.5971 19.5 20 19.9029 20 20.4C20 20.8971 19.5971 21.3 19.1 21.3H0.899999C0.402943 21.3 0 20.8971 0 20.4C0 19.9029 0.402944 19.5 0.9 19.5H19.1ZM17 24.9C17 24.4029 16.5971 24 16.1 24H0.9C0.402944 24 0 24.4029 0 24.9C0 25.3971 0.402943 25.8 0.899999 25.8H16.1C16.5971 25.8 17 25.3971 17 24.9Z"
                                      fill="#8D9CAE"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M16 14.1774H16.37C16.6351 14.1774 16.85 13.9625 16.85 13.6974V10.835C16.85 10.5699 16.6351 10.355 16.37 10.355H16.0171V9.5L18.185 9.5V13.6974C18.185 13.9625 18.3999 14.1774 18.665 14.1774H19V15H16V14.1774Z"
                                      fill="#8D9CAE"></path>
                            </svg>
                        </div>
                        <div style="flex: 3 1;margin-left: .85rem;">
                            <div class="dropdown-title">bullet</div>
                            <div class="dropdown-subtitle">Medium section heading</div>
                        </div>
                    </div>
                    <a onclick="toggleTrixAttribute(this.parentNode)"></a>
                </li>
                <li tabindex="-1" id="number" class="not-selected">
                    <div style="padding: .75rem; margin-bottom: 0; display: inline-flex; width: 100%;">
                        <div class="icon-preview">
                            <svg width="20" height="26" viewBox="0 0 20 26" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M0 0H6.41485V1.06838H5.42198C4.805 1.06838 4.30484 1.56854 4.30484 2.18551V6.42305H10.7187V2.18551C10.7187 1.56854 10.2185 1.06838 9.60157 1.06838H8.58509V0H15V1.06838H13.9945C13.3775 1.06838 12.8774 1.56854 12.8774 2.18551V12.8037C12.8774 13.4206 13.3775 13.9208 13.9945 13.9208H15V15H8.58509V13.9208H9.60157C10.2185 13.9208 10.7187 13.4206 10.7187 12.8037V7.5H4.30484V12.8037C4.30484 13.4206 4.805 13.9208 5.42198 13.9208H6.41485V15H0V13.9208H1.031C1.64798 13.9208 2.14814 13.4206 2.14814 12.8037V2.18552C2.14814 1.56854 1.64798 1.06838 1.031 1.06838H0V0ZM19.1 19.5C19.5971 19.5 20 19.9029 20 20.4C20 20.8971 19.5971 21.3 19.1 21.3H0.899999C0.402943 21.3 0 20.8971 0 20.4C0 19.9029 0.402944 19.5 0.9 19.5H19.1ZM17 24.9C17 24.4029 16.5971 24 16.1 24H0.9C0.402944 24 0 24.4029 0 24.9C0 25.3971 0.402943 25.8 0.899999 25.8H16.1C16.5971 25.8 17 25.3971 17 24.9Z"
                                      fill="#8D9CAE"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M16 14.1774H16.37C16.6351 14.1774 16.85 13.9625 16.85 13.6974V10.835C16.85 10.5699 16.6351 10.355 16.37 10.355H16.0171V9.5L18.185 9.5V13.6974C18.185 13.9625 18.3999 14.1774 18.665 14.1774H19V15H16V14.1774Z"
                                      fill="#8D9CAE"></path>
                            </svg>
                        </div>
                        <div style="flex: 3 1;margin-left: .85rem;">
                            <div class="dropdown-title">number</div>
                            <div class="dropdown-subtitle">Medium section heading</div>
                        </div>
                    </div>
                    <a onclick="toggleTrixAttribute(this.parentNode)"></a>
                </li>
                <li tabindex="-1" id="heading2" class="not-selected">
                    <div style="padding: .75rem; margin-bottom: 0; display: inline-flex; width: 100%;">
                        <div class="icon-preview">
                            <svg width="20" height="26" viewBox="0 0 20 26" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M0 0H6.41485V1.06838H5.42198C4.805 1.06838 4.30484 1.56854 4.30484 2.18551V6.42305H10.7187V2.18551C10.7187 1.56854 10.2185 1.06838 9.60157 1.06838H8.58509V0H15V1.06838H13.9945C13.3775 1.06838 12.8774 1.56854 12.8774 2.18551V12.8037C12.8774 13.4206 13.3775 13.9208 13.9945 13.9208H15V15H8.58509V13.9208H9.60157C10.2185 13.9208 10.7187 13.4206 10.7187 12.8037V7.5H4.30484V12.8037C4.30484 13.4206 4.805 13.9208 5.42198 13.9208H6.41485V15H0V13.9208H1.031C1.64798 13.9208 2.14814 13.4206 2.14814 12.8037V2.18552C2.14814 1.56854 1.64798 1.06838 1.031 1.06838H0V0ZM19.1 19.5C19.5971 19.5 20 19.9029 20 20.4C20 20.8971 19.5971 21.3 19.1 21.3H0.899999C0.402943 21.3 0 20.8971 0 20.4C0 19.9029 0.402944 19.5 0.9 19.5H19.1ZM17 24.9C17 24.4029 16.5971 24 16.1 24H0.9C0.402944 24 0 24.4029 0 24.9C0 25.3971 0.402943 25.8 0.899999 25.8H16.1C16.5971 25.8 17 25.3971 17 24.9Z"
                                      fill="#8D9CAE"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M16 14.1774H16.37C16.6351 14.1774 16.85 13.9625 16.85 13.6974V10.835C16.85 10.5699 16.6351 10.355 16.37 10.355H16.0171V9.5L18.185 9.5V13.6974C18.185 13.9625 18.3999 14.1774 18.665 14.1774H19V15H16V14.1774Z"
                                      fill="#8D9CAE"></path>
                            </svg>
                        </div>
                        <div style="flex: 3 1;margin-left: .85rem;">
                            <div class="dropdown-title">attachFiles</div>
                            <div class="dropdown-subtitle">Medium section heading</div>
                        </div>
                    </div>
                    <a onclick="toggleTrixAttribute(this.parentNode)"></a>
                </li>
                <li tabindex="-1" id="heading2" class="not-selected">
                    <a onclick="toggleTrixAttribute(this.parentNode)">
                        <div style="padding: .75rem; margin-bottom: 0; display: inline-flex; width: 100%;">
                            <div class="icon-preview">
                                <svg width="20" height="26" viewBox="0 0 20 26" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M0 0H6.41485V1.06838H5.42198C4.805 1.06838 4.30484 1.56854 4.30484 2.18551V6.42305H10.7187V2.18551C10.7187 1.56854 10.2185 1.06838 9.60157 1.06838H8.58509V0H15V1.06838H13.9945C13.3775 1.06838 12.8774 1.56854 12.8774 2.18551V12.8037C12.8774 13.4206 13.3775 13.9208 13.9945 13.9208H15V15H8.58509V13.9208H9.60157C10.2185 13.9208 10.7187 13.4206 10.7187 12.8037V7.5H4.30484V12.8037C4.30484 13.4206 4.805 13.9208 5.42198 13.9208H6.41485V15H0V13.9208H1.031C1.64798 13.9208 2.14814 13.4206 2.14814 12.8037V2.18552C2.14814 1.56854 1.64798 1.06838 1.031 1.06838H0V0ZM19.1 19.5C19.5971 19.5 20 19.9029 20 20.4C20 20.8971 19.5971 21.3 19.1 21.3H0.899999C0.402943 21.3 0 20.8971 0 20.4C0 19.9029 0.402944 19.5 0.9 19.5H19.1ZM17 24.9C17 24.4029 16.5971 24 16.1 24H0.9C0.402944 24 0 24.4029 0 24.9C0 25.3971 0.402943 25.8 0.899999 25.8H16.1C16.5971 25.8 17 25.3971 17 24.9Z"
                                          fill="#8D9CAE"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M16 14.1774H16.37C16.6351 14.1774 16.85 13.9625 16.85 13.6974V10.835C16.85 10.5699 16.6351 10.355 16.37 10.355H16.0171V9.5L18.185 9.5V13.6974C18.185 13.9625 18.3999 14.1774 18.665 14.1774H19V15H16V14.1774Z"
                                          fill="#8D9CAE"></path>
                                </svg>
                            </div>
                            <div style="flex: 3 1;margin-left: .85rem;">
                                <div class="dropdown-title">heading2</div>
                                <div class="dropdown-subtitle">Medium section heading</div>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <div id="link-modal" class="link-modal" style="display: none; margin-top: 3rem;">
            <div
                style="position: fixed; top: 0; left: 0; display: flex; width: 100%; right: 0; bottom: 0; align-items: center; height: 100vh; background: rgba(23,47,68,.8); z-index: 100;">
                <div style="max-width: 800px; margin: auto;">
                    <div>
                        <div>
                            <div style="box-sizing: border-box; border: 0 solid #e9e9e9;">
                                <ol
                                    style="border-bottom: 1px solid #e6e8ec; color: #667389; padding-left: 0!important;">
                                    <li class="tab-list-item tab-list-active"
                                        style="font-weight: 600; color: #1f2838; border: none; border-bottom: 2px solid #506cf0;">
                                        Add link
                                    </li>
                                </ol>
                                <div class="tab-content" style="box-sizing: border-box; border: 0 solid #e9e9e9;">
                                    <input class="upload-input" placeholder="Paste the image file link..." type="text"
                                           value=""
                                           style="border-width: 1px; width: 100%; background: #f4f4f7; border-radius: .35rem; padding: .75rem 1rem; display: block; outline: 0; box-shadow: none; margin-top: .75rem; border-width: 0!important; margin-bottom: 2rem;">
                                    <button onclick="linkProcess()"
                                            style="display: block; right: auto; bottom: auto; position: static; margin: 1rem auto; height: 46px; line-height: 44px; padding-left: 20px; padding-right: 20px; color: #fff; background-color: #506cf0; border-color: #506cf0; border-width: 1px;">
                                        Link
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="embed-modal" class="embed-modal" style="display: none; margin-top: 3rem;">
            <div
                style="position: fixed; top: 0; left: 0; display: flex; width: 100%; right: 0; bottom: 0; align-items: center; height: 100vh; background: rgba(23,47,68,.8); z-index: 100;">
                <div style="max-width: 800px; margin: auto;">
                    <div>
                        <div>
                            <div style="box-sizing: border-box; border: 0 solid #e9e9e9;">
                                <ol
                                    style="border-bottom: 1px solid #e6e8ec; color: #667389; padding-left: 0!important;">
                                    <li class="tab-list-item tab-list-active"
                                        style="font-weight: 600; color: #1f2838; border: none; border-bottom: 2px solid #506cf0;">
                                        Add link to Embed
                                    </li>
                                </ol>
                                <div class="tab-content" style="box-sizing: border-box; border: 0 solid #e9e9e9;">
                                    <input class="upload-input" placeholder="Paste the image file link..." type="text"
                                           value=""
                                           style="border-width: 1px; width: 100%; background: #f4f4f7; border-radius: .35rem; padding: .75rem 1rem; display: block; outline: 0; box-shadow: none; margin-top: .75rem; border-width: 0!important; margin-bottom: 2rem;">
                                    <button onclick="embedProcess()"
                                            style="display: block; right: auto; bottom: auto; position: static; margin: 1rem auto; height: 46px; line-height: 44px; padding-left: 20px; padding-right: 20px; color: #fff; background-color: #506cf0; border-color: #506cf0; border-width: 1px;">
                                        Link
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset("js/custom-trix.js") }}"></script>
@endsection
