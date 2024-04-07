import "./bootstrap";
import { createApp } from "vue";

const app = createApp({});

import ExampleComponent from "./components/ExampleComponent.vue";
app.component("example-component", ExampleComponent);

app.mount("#app");
addEvents();

function addEvents() {
    const triangle = document.querySelector(".show-deleted-memo");
    const content = document.querySelector(".deleted-memo-content");
    if (!triangle || !content) {
        return;
    }
    triangle.addEventListener("click", () => {
        triangle.classList.toggle("active");

        content.classList.toggle(
            "showing",
            triangle.classList.contains("active")
        );
    });
}

function submitForm(action) {
    // var form = document.getElementById("restore-form");
    // form.action = action;
    // form.method = "POST";
    // form.submit();
    console.log(action);
}
