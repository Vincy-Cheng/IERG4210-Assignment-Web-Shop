<?php
require __DIR__ . '/lib/db.inc.php';
$res = ierg4210_cat_fetchall();
$options = '';

foreach ($res as $value) {
    $options .= '<option value="' . $value["CATID"] . '"> ' . $value["NAME"] . ' </option>';
}

?>

<html>

<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css?v=<?php echo time();?>">

</head>

<body>
    
    <header>
        <h1>IERG 4210 e-shop admin panel</h1>
        <a href="/">Back to index page</a>
    </header>
    <table id="admin-panel">
        <tr>
            <td>
                <fieldset class="cat">
                    <legend class="cat-legend"> New Category</legend>
                    <form id="cat_insert" method="POST" action="admin-process.php?action=cat_insert" enctype="multipart/form-data">
                        <label for="cat_name">Name *</label>
                        <div> <input id="cat_name" type="text" name="name" required="required" pattern="^[\w\-]+$" /></div>
                        <input class="panel-submit" type="submit" value="Submit" />
                    </form>
                </fieldset>
            </td>
            <td>
                <fieldset class="cat">
                    <legend class="cat-legend"> Delete Category</legend>
                    <form id="cat_insert" method="POST" action="admin-process.php?action=cat_delete" enctype="multipart/form-data">
                        <label for="cat_id"> Delete by CATID *</label>
                        <div> <input id="cat_id" type="number" name="catid" required="required" pattern="^\d*$" /></div>
                        <input class="panel-submit" type="submit" value="Submit" />
                    </form>
                </fieldset>
            </td>
        </tr>
        <tr>
            <td>
                <fieldset class="cat">
                    <legend class="cat-legend"> Edit Category</legend>
                    <form id="cat_insert" method="POST" action="admin-process.php?action=cat_edit" enctype="multipart/form-data">
                        <label for="prod_pid">CATID *</label>
                        <div> <input id="cat_id" type="number" name="catid" required="required" pattern="^\d*$" /></div>
                        <label for="cat_name">Name *</label>
                        <div> <input id="cat_name" type="text" name="name" required="required" pattern="^[\w\-]+$" /></div>
                        <input class="panel-submit" type="submit" value="Submit" />
                    </form>
                </fieldset>
            </td>
        </tr>
        <tr>
            <td>
                <fieldset class="prod">
                    <legend class="prod-legend"> New Product</legend>
                    <form id="prod_insert" method="POST" action="admin-process.php?action=prod_insert" enctype="multipart/form-data">
                        <label for="prod_catid"> Category *</label>
                        <div> <select id="prod_catid" name="catid"><?php echo $options; ?></select></div>
                        <label for="prod_name"> Name *</label>
                        <div> <input id="prod_name" type="text" name="name" required="required" pattern="^[\w\- ]+$" /></div>
                        <label for="prod_price"> Price *</label>
                        <div> <input id="prod_price" type="text" name="price" required="required" pattern="^\d+\.?\d*$" /></div>
                        <label for="prod_quantity"> Quantity *</label>
                        <div> <input id="prod_quantity" type="number" name="quantity" required="required" pattern="^\d*$" /></div>
                        <label for="prod_desc"> Description *</label>
                        <div> <textarea id="prod_desc" type="text" name="description"></textarea> </div>
                        <label for="prod_image"> Image * </label>
                        <div class="drop-zone">
                            <!-- <div class="drop-zone-prompt"></div> -->
                            <span class="drop-zone-prompt">Drop file to here <br>or <br>CLICK Me to upload</span>
                            <input class="drop-zone-input" type="file" name="file" required="true" accept="image/jpeg" hidden />
                        </div>

                        <input class="panel-submit" type="submit" value="Submit" />
                    </form>
                </fieldset>
            </td>
            <td>
                <fieldset class="prod">
                    <legend class="prod-legend"> Edit Product </legend>
                    <form id="prod_insert" method="POST" action="admin-process.php?action=prod_edit" enctype="multipart/form-data">
                        <label for="prod_pid"> PID *</label>
                        <div> <input id="prod_pid" type="number" name="pid" required="required" pattern="^\d*$" /></div>
                        <label for="prod_name"> Name *</label>
                        <div> <input id="prod_name" type="text" name="name" required="required" pattern="^[\w\- ]+$" /></div>
                        <label for="prod_price"> Price *</label>
                        <div> <input id="prod_price" type="text" name="price" required="required" pattern="^\d+\.?\d*$" /></div>
                        <label for="prod_quantity"> Quantity *</label>
                        <div> <input id="prod_quantity" type="number" name="quantity" required="required" pattern="^\d*$" /></div>
                        <label for="prod_desc"> Description *</label>
                        <div> <textarea id="prod_desc" type="text" name="description"></textarea> </div>
                        <label for="prod_image"> Image * </label>
                        <div class="drop-zone">
                            <!-- <div class="drop-zone-prompt"></div> -->
                            <span class="drop-zone-prompt">Drop file to here <br>or <br>CLICK Me to upload</span>
                            <input class="drop-zone-input" type="file" name="file" required="true" accept="image/jpeg"  hidden/>
                        </div>
                        <input class="panel-submit" type="submit" value="Submit" />
                    </form>
                </fieldset>
            </td>
        </tr>
        <tr>
            <td>
                <fieldset class="prod">
                    <legend class="prod-legend"> Delete Product by CATID</legend>
                    <form id="prod_insert" method="POST" action="admin-process.php?action=prod_delete_by_catid" enctype="multipart/form-data">
                        <label for="prod_pid">CATID *</label>
                        <div> <input id="prod_catid" type="number" name="catid" required="required" pattern="^\d*$" /></div>
                        <input class="panel-submit" type="submit" value="Submit" />
                    </form>
                </fieldset>
            </td>
            <td>
                <fieldset class="prod">
                    <legend class="prod-legend"> Delete Product by PID</legend>
                    <form id="prod_insert" method="POST" action="admin-process.php?action=prod_delete" enctype="multipart/form-data">
                        <label for="prod_pid"> Delete by PID *</label>
                        <div> <input id="prod_pid" type="number" name="pid" required="required" pattern="^\d*$" /></div>
                        <input class="panel-submit" type="submit" value="Submit" />
                    </form>
                </fieldset>
            </td>
        </tr>
    </table>
    <script src="panel.js"></script>
</body>

</html>

<!-- regular expression reference link -->
<!-- https://dl.icewarp.com/online_help/203030104.htm -->