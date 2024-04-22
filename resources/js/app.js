require("./bootstrap");

import Alpine from "alpinejs";
import $ from "jquery";
import Swal from "sweetalert2";

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

window.$ = window.jQuery = $;

window.Swal = Swal;

window.Alpine = Alpine;

Alpine.start();


