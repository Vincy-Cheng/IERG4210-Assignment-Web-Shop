// admin-process.php?action=cat_delete

// 1. update form input when add new item or change the amount
// 2. use AJAX to pass pid and quantity to server
// 3. server return 


window.onload = function () {
    for (let index = 0; index < localStorage.length; index++) {
        if (localStorage.key(index) == "__paypal_storage__") {
            continue
        }
        get_product_name(localStorage.key(index));
    }
    // var page = document.querySelectorAll(".product-list");
    //document.getElementsByClassName("shopping-title")[0].innerHTML = "<i class='fa-solid fa-cart-shopping'></i> Shopping List $0.0"
    // if (page.length>1) {
    //     for (let index = 1; index < page.length; index++) {
    //         page[index].classList.add("d-none");
    //     }
    // }
    setTimeout(function () {
        addforminput()
    }, 1000)

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
            element.classList.add("cart-detail", "cart-name");
            element.innerHTML = this.responseText;

            var button = document.querySelector("#form1");
            document.querySelector(".shopping-detail").insertBefore(add, button);
            // document.querySelector("#form1").appendChild(add)
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
                    document.getElementsByClassName("shopping-title")[0].innerHTML = "<i class='fa-solid fa-cart-shopping'></i> Shopping List $" + total.toFixed(1)
                    document.querySelector(".cart-total").innerHTML = "Total: $" + total.toFixed(1)
                }

            }

        }

    }
    if (total == 0 || localStorage.length == 0) {
        document.getElementsByClassName("shopping-title")[0].innerHTML = "<i class='fa-solid fa-cart-shopping'></i> Shopping List $" + total
        document.querySelector(".cart-total").innerHTML = "Total: $0.0"

    }
    setTimeout(function () {
        changeforminput()
    }, 1000)



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
            changeforminput()

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

            changeforminput()

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

function addforminput() {
    var form = document.querySelector("#form1")
    var i = 0
    for (let index = 0; index < localStorage.length; index++) {

        if (localStorage.key(index) == "__paypal_storage__") {
            //console.log("detected")
            i++
            continue
        }
        //console.log(index)
        var element1 = document.createElement("input")
        element1.type = "hidden"
        element1.name = "item_name_" + (index - i + 1)
        element1.className = "input_item"
        var itemname = document.querySelector("#cart-product" + localStorage.key(index))
        //console.log(itemname)
        element1.value = itemname.querySelector(".cart-name").innerHTML.replace(/\n/g, "")
        form.appendChild(element1)
        var element2 = document.createElement("input")
        element2.type = "hidden"
        element2.name = "item_number_" + (index - i + 1)
        element2.value = localStorage.key(index)
        element2.className = "input_item"
        form.appendChild(element2)
        var element3 = document.createElement("input")
        element3.type = "hidden"
        element3.name = "quantity_" + (index - i + 1)
        element3.value = itemname.querySelector(".cart-prod-quan").value
        element3.className = "input_item"
        form.appendChild(element3)
        var element4 = document.createElement("input")
        element4.type = "hidden"
        element4.name = "amount_" + (index - i + 1)
        element4.value = itemname.querySelector(".cart-price").innerHTML.replace(/\n/g, "")
        element4.className = "input_item"
        form.appendChild(element4)
    }
}

function changeforminput() {
    var form = document.querySelector("#form1")
    var i = form.querySelectorAll(".input_item")
    i.forEach(each => {
        form.removeChild(each)
    })

    addforminput()

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

function formsubmit(event) {
    event.preventDefault()
    //alert('I will not submit');
    //var xmlhttp = new XMLHttpRequest();
    // xmlhttp.onreadystatechange = function () {
    //     if (this.readyState == 4 && this.status == 200) {

    //         console.log(this.responseText)
    //     }
    // };
    var json = []
    for (let index = 0; index < localStorage.length; index++) {
        json[String(localStorage.key(index))] = localStorage.getItem(String(localStorage.key(index)))
    }
    //var data = {name:'yogesh',salary: 35000,email: 'yogesh@makitweb.com'};
    //json = json.join("&")
    // xmlhttp.open("POST", "get_prod.php?action=checkout", true);
    // xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    // xmlhttp.send(json);
    // console.log(json)
    // console.log(JSON.stringify(json))
    var username = document.querySelector("#User").innerHTML.replace(/ /g, '')
    if (username != "GUEST") {
        var s = username.split("isloggedin.")
        username = s[0]
    }
    console.log(json);
    //console.log(username)
    $.ajax({
        url: "get_prod.php?action=checkout&username=" + username,
        type: 'POST',
        data: json,
        success: function (msg) {
            msg = msg.replace("\n", "")
            var j = JSON.parse(String(msg))

            var form = document.querySelector("#form1")
            var element1 = document.createElement("input")
            element1.type = "hidden"
            element1.name = "invoice"
            element1.value = j["invoice"]

            var element2 = document.createElement("input")
            element2.type = "hidden"
            element2.name = "custom"
            element2.value = j["custom"]
            //console.log(j['custom'])
            //console.log(j['invoice'])
            form.appendChild(element1)
            form.appendChild(element2)
            localStorage.clear();
            //console.log(JSON.stringify(msg))
             ccccconsole.log(msg)
            form.submit();
        }

    });
    return false
}

function signupsubmit(event) {
    event.preventDefault();

    var email = document.querySelector("#signup_email");
    var username = document.querySelector("#signup_username");
    var pwd = document.querySelector("#signup_pwd");
    var conpwd = document.querySelector("#signup_conpwd");

    if (email.value.length < 1) {
        email.classList.add("is-invalid")
    }
    else if (pwd.value.length < 1) {
        pwd.classList.add("is-invalid")
    }
    else if (username.value.length < 1) {
        username.classList.add("is-invalid")
    }
    else if (pwd.value !== conpwd.value) {
        conpwd.classList.add("is-invalid")
    }
    else {
        document.querySelector("#sigupform").submit
    }
    return false
}

function loadorder(event) {
    event.preventDefault();
    var form = document.querySelector("#order_table")
    var invoice = document.querySelector("#order_invoice").value;
    var digest = document.querySelector("#order_digest").value;
    var json = {
        "invoice": invoice,
        "digest": digest
    }
    $.ajax({
        url: "get_prod.php?action=loadorder",
        type: 'POST',
        data: json,
        success: function (msg) {
            
            //console.log(JSON.parse(msg))
            var data = JSON.parse(msg)
            var ts = form.querySelectorAll("table");
            ts.forEach(tableelement=>{
                form.removeChild(tableelement)
            })
            var element = document.createElement("table");
            element.className = "table table-bordered"
            var thread1 = document.createElement("thead")
            var tr1 = document.createElement("tr")
            var th1 = document.createElement("th");
            th1.innerHTML = "Invoice number";
            var th2 = document.createElement("th");
            th2.innerHTML = "TXN ID";
            // var th3 = document.createElement("th");
            // th3.innerHTML = "Digested order message";
            // var th4 = document.createElement("th");
            // th4.innerHTML = "Salt";
            var th3 = document.createElement("th");
            th3.innerHTML = "Currency"
            var th5 = document.createElement("th");
            th5.innerHTML = "Payment Type";
            var th6 = document.createElement("th");
            th6.innerHTML = "Payment Status";
            var th7 = document.createElement("th");
            th7.innerHTML = "Product List";
            var th8 = document.createElement("th");
            th8.innerHTML = "Total";
            var th9 = document.createElement("th");
            th9.innerHTML = "Customer";
            tr1.appendChild(th1)
            tr1.appendChild(th2)
            tr1.appendChild(th3)
            //tr1.appendChild(th4)
            tr1.appendChild(th5)
            tr1.appendChild(th6)
            tr1.appendChild(th7)
            tr1.appendChild(th8)
            tr1.appendChild(th9)
            thread1.appendChild(tr1)
            element.appendChild(thread1)
            form.appendChild(element)
            if (data.length > 0) {
                var thread2 = document.createElement("thead")
                var tr = document.createElement("tr")
                var td1 = document.createElement("td");
                td1.innerHTML = data[0]["UUID"];
                var td2 = document.createElement("td");
                td2.innerHTML = data[0]["TXNID"];
                var td3 = document.createElement("td");
                td3.innerHTML = data[0]["CURRENCY"];
                // var td4 = document.createElement("td");
                // td4.innerHTML = data[0]["SALT"];
                var td5 = document.createElement("td");
                td5.innerHTML = data[0]["PAYMENT_TYPE"];
                var td6 = document.createElement("td");
                td6.innerHTML = data[0]["PAYMENT_STATUS"];
                var td7 = document.createElement("td");
                td7.innerHTML = data[0]["PRODUCT_LIST"];
                var td8 = document.createElement("td");
                td8.innerHTML = data[0]["PAYMENT_AMOUNT"];
                var td9 = document.createElement("td");
                td9.innerHTML = data[0]["USERNAME"];
                tr.appendChild(td1)
                tr.appendChild(td2)
                tr.appendChild(td3)
                //tr.appendChild(td4)
                tr.appendChild(td5)
                tr.appendChild(td6)
                tr.appendChild(td7)
                tr.appendChild(td8)
                tr.appendChild(td9)
                thread2.appendChild(tr)
                element.appendChild(thread2)
            }
        }

    });
    return false
}