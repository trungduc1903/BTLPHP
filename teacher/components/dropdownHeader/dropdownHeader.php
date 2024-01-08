<div class="dropdown">
    <button onclick="dropdown()" class="drop-icon" type="button">
        <i class=" drop-icon far fa-chevron-down"></i>
    </button>
    <div id="jsDropdown" class="dropdown-content">
        <a href="./index.php?page=account">
            <div class="dropdown-item">
                Tài khoản
            </div>
        </a>
        <a href="./index.php?page=security">
            <div class="dropdown-item">
                Bảo mật
            </div>
        </a>
        <a href="./logout.php">
            <div class="dropdown-item">Đăng xuất</div>
        </a>
    </div>
</div>

<style>
    .dropdown button {
        border: unset;
        width: 16px;
        height: 16px;
        cursor: pointer;
        background-color: unset;
    }

    .dropdown {
        position: relative;
    }
    .dropdown a{
        text-decoration: none;
        color: black;
    }
    .dropdown-content {
        position: absolute;
        display: none;
        right: 0;
        top: 42px;
        list-style: none;
        background-color: #f1f1f1;
        min-width: 150px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-item {
        display: block;
        white-space: nowrap;
        padding: 8px;
        cursor: pointer;
        border-radius: 4px;

    }

    .dropdown-item a {
        text-decoration: none;
        color: black;
    }

    .dropdown-item:hover {
        background-color: #04143422;
        font-weight: bold;
    }

    .show-dropdown {
        display: flex;
        flex-direction: column;
        padding: 8px;
        background-color: rgb(255, 255, 255);
        list-style: none;
        box-shadow: 0px 0px 10px rgb(168, 167, 167);
        border-radius: 5px;
        margin-top: 0px;
    }
</style>

<script>
    // Js - Dropdown - Start

    const jsDropdown = document.getElementById("jsDropdown");

    function dropdown() {
        jsDropdown.classList.toggle("show-dropdown");
    }
    document.documentElement.addEventListener("click", function(event) {
        if (!event.target.matches('.drop-icon')) {
            if (jsDropdown.classList.contains("show-dropdown")) {
                jsDropdown.classList.toggle("show-dropdown");
            }
        }
    });

    // Js - Dropdown - End
</script>