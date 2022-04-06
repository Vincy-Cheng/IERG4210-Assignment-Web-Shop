// admin-process.php?action=cat_delete
window.onload = function () {
    for (let index = 0; index < localStorage.length; index++) {
        get_product_name(localStorage.key(index));
    }
    var page = document.querySelectorAll(".product-list");
    //document.getElementsByClassName("shopping-title")[0].innerHTML = "<i class='fa-solid fa-cart-shopping'></i> Shopping List $0.0"
    // if (page.length>1) {
    //     for (let index = 1; index < page.length; index++) {
    //         page[index].classList.add("d-none");
    //     }
    // }
}
function get_product_name(pid) {
    // get the product name by AJAX with pid
    //console.log("get-in-name")
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var add = document.createElement("div");
            var element = document.createElement("div");
            add.className = "row";
            add.classList.add("mx-auto", "my-2", "cart-product");
            add.id = "cart-product" + pid;
            element.className = "col-5";
            element.classList.add("cart-detail");
            element.innerHTML = this.responseText;

            var button = document.querySelector(".cart-total").parentNode;
            document.querySelector(".shopping-detail").insertBefore(add, button);
            add.appendChild(element);
            get_product_price(pid);
        }
    };
    xmlhttp.open("GET", "get_prod.php?action=name&q=" + pid, true);
    xmlhttp.send();
}
function get_product_price(pid) {
    // get the product price by AJAX with pid
    //console.log("get-in-price")
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var prod = document.getElementById("cart-product" + pid);
            var element = document.createElement("div");
            element.className = "col-3 cart-detail cart-price";
            element.innerHTML = this.responseText;

            prod.appendChild(element);
            show_prod_quan(pid);

        }
    };
    xmlhttp.open("GET", "get_prod.php?action=price&q=" + pid, true);
    xmlhttp.send();
}

function sumAllprod() {
    // calculate the total of shopping cart
    var total = 0;
    //console.log(document.getElementById("cart-product" + 8))
    for (let index = 0; index < localStorage.length; index++) {
        var pid = Number(localStorage.key(index))
        //console.log("check-point-1")
        if (document.querySelector("#cart-product" + pid)) {
            if (document.querySelector("#cart-product" + pid).hasChildNodes()) {
                if (document.querySelector("#cart-product" + pid).childNodes[1]) {
                    var getting_price = document.querySelector("#cart-product" + pid).childNodes[1].innerHTML
                    //console.log("check-point-2")
                    getting_price = getting_price.split('\n')
                    //console.log("check-point-3")
                    var price = getting_price[1]
                    var quan = localStorage.getItem(pid)
                    total += price * quan
                    document.getElementsByClassName("shopping-title")[0].innerHTML = "<i class='fa-solid fa-cart-shopping'></i> Shopping List $" + total
                    document.querySelector(".cart-total").innerHTML = "Total: $" + total
                }

            }

        }

    }
    if (total == 0 || localStorage.length == 0) {
        document.getElementsByClassName("shopping-title")[0].innerHTML = "<i class='fa-solid fa-cart-shopping'></i> Shopping List $" + total
        document.querySelector(".cart-total").innerHTML = "Total: $0.0"

    }

}

document.querySelectorAll(".add-cart-btn").forEach(AddElement => {
    //console.log("get-in-add")
    AddElement.addEventListener("click", e => {
        var pid = AddElement.nextElementSibling.value;
        //console.log(pid);
        var str_pid = String(pid);
        // console.log("add")
        if (!localStorage.getItem(str_pid)) {
            localStorage.setItem(str_pid, 1);
            get_product_name(str_pid);
            sumAllprod();
        }
        else {
            var quan = localStorage.getItem(str_pid);
            quan = Number(quan) + 1
            localStorage.setItem(str_pid, quan)
            // console.log("changing")
            // console.log(document.querySelector("#cart-product"+str_pid).childNodes[2].childNodes[0].value)
            document.querySelector("#cart-product" + str_pid).childNodes[2].childNodes[0].value = quan
            sumAllprod();
        }

    });
});

function Check_remove_btn() {
    //console.log("get-in-change-remove")
    document.querySelectorAll(".cart-remove-btn").forEach(RemoveElement => {
        // console.log(RemoveElement);
        RemoveElement.addEventListener("click", e => {
            //console.log("click");
            var remove = RemoveElement.parentNode.parentNode;
            //console.log(remove)
            var get_pid = remove.id;
            var array = get_pid.split('cart-product');
            var pid = array[1];
            //console.log("point-check-1")
            localStorage.removeItem(String(pid));
            //console.log("point-check-2")
            remove.remove()
            //console.log("finish")
            //document.querySelector(".cart-total").innerHTML = "Total: $100000"
            sumAllprod();
        });
    });


}

function Check_quan_change() {
    //console.log("get-in-change-quan")
    document.querySelectorAll(".cart-prod-quan").forEach(ChangeElement => {
        // console.log(RemoveElement);
        ChangeElement.addEventListener("change", e => {
            var value = ChangeElement.value;
            //console.log("click");
            var change = ChangeElement.parentNode.parentNode;
            //console.log(remove)
            var get_pid = change.id;
            var array = get_pid.split('cart-product');
            var pid = array[1];
            localStorage.setItem(String(pid), value)
            sumAllprod();
            //document.querySelector(".cart-total").innerHTML = "Total: $100000"
        });
    });
}

// document.querySelectorAll("#check-out-btn").forEach(check => {
//     check.addEventListener("click", e => {
//         //console.log("check");
//     })
// })

function show_prod_quan(pid) {
    //console.log("get-in-quan")
    var prod = document.getElementById("cart-product" + pid);
    var element = document.createElement("div");
    element.className = "col-4 cart-detail";
    var str_pid = String(pid);
    var quan = localStorage.getItem(str_pid);
    // element.innerHTML = quan;
    var input = "<input type='number' class='cart-prod-quan' value=" + quan + " min=1>";
    input += "<button type='button' class='cart-remove-btn btn text-danger mx-2 my-auto'><i class='fa-solid fa-trash-can'></i></button>";
    element.innerHTML = input;
    prod.appendChild(element);
    sumAllprod();
    Check_remove_btn();
    Check_quan_change();
}



document.querySelectorAll(".page-btn").forEach(pageElement => {

    pageElement.addEventListener("click", function () {
        var total_page = document.querySelectorAll(".product-list");
        for (let index = 1; index <= total_page.length; index++) {
            if (pageElement.innerHTML == String(index)) {
                total_page[index - 1].classList.remove("d-none");
            }
            else {
                total_page[index - 1].classList.add("d-none")
            }
        }
    })
})
