require('./bootstrap');

import Swal from "sweetalert2";

document.addEventListener("DOMContentLoaded", function () {
    const deleteForm = document.querySelectorAll(".delete-form");
        deleteForm.forEach((_form) => {
        _form.addEventListener("submit", function (e) {
            e.preventDefault();
            Swal.fire({
                title: "Confirm Delete",
                text: "Are you sure you want to delete this record?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
            }).then((result) => {
                if (result.isConfirmed) {
                    _form.submit();
                } else {
                    return false;
                }
            });
        });
    });
});
