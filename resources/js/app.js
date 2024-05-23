require("./bootstrap");

import Alpine from "alpinejs";
import $ from "jquery";
import Swal from "sweetalert2";
import toastr from "toastr";

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

window.$ = window.jQuery = $;

window.toastr = toastr;

window.Swal = Swal;

window.Alpine = Alpine;

Alpine.start();
