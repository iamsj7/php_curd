<?php
//database connection file
include ('dbconnection.php');
//Code for deletion
if (isset ($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    $profilepic = $_GET['ppic'];
    $ppicpath = "profilepics" . "/" . $profilepic;
    $sql = mysqli_query($con, "delete from tblusers where ID=$rid");
    unlink($ppicpath);
    echo "<script>alert('Data deleted');</script>";
    echo "<script>window.location.href = 'index.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Docs - Academy of strategic studies</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <style>
    body {
        color: #566787;
        background: #F0E7D8;
        font-family: 'Roboto', sans-serif;
    }

    .table {
        border: 1px solid #000;
        background: #fff;
    }

    .table thead th {
        background: linear-gradient(to bottom, #18646a, #bf9f21);
        color: #fff;
        border: 1px solid #000;
    }

    .table td,
    .table th {
        border: 1px solid #000;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .hidden-column {
        display: none;
    }
    </style>
</head>

<body>
    <!-- Logo and text -->
    <div class="container mt-4">
        <div class="row">
            <div class="col text-center">
                <img src="logo.png" alt="Logo" width="200">

            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row">
            <div class="col text-center">
                <img src="title_logo.png" alt="Logo" width="600">

            </div>
        </div>
    </div>
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-7" align="right">
                            <a href="insert.php" title="تحميل الوثائق (المستندات)">
                                <img src="upload_icon.svg" alt="Upload Icon" class="upload-icon">
                            </a>
                            <a href="index.php" title="تحديث الصفحة">
                                <img src="refresh_icon.svg" alt="Refresh Icon" class="refresh-icon">
                            </a>
                            <a href="#" title="Enter Password" id="passwordIcon" data-toggle="modal"
                                data-target="#passwordModal">
                                <img src="password_icon.svg" alt="Password Icon" class="password-icon">
                            </a>
                            <a href="quality_control.php" title="ربط مع مديرية ضبط الجودة">
                                <img src="quality_icon.svg" alt="Quality Icon" class="quality-icon">
                            </a>
                        </div>
                    </div>
                </div>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>رقم التسلسلي</th>
                            <th>دليل الاعتماد الاكاديمي</th>
                            <th>عنوان الدليل</th>
                            <th>التصنيف</th>
                            <th>المديرية</th>
                            <th>القسم / الخلية</th>
                            <th class="hidden-column">إدارة الوثائق</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ret = mysqli_query($con, "select * from tblusers");
                        $cnt = 1;
                        $row = mysqli_num_rows($ret);
                        if ($row > 0) {
                            while ($row = mysqli_fetch_array($ret)) {
                                ?>
                        <!--Fetch the Records -->
                        <tr>
                            <td>
                                <?php echo $cnt; ?>
                            </td>
                            <td>
                                <?php echo $row['AcademicGuide']; ?>
                            </td>
                            <td>
                                <?php echo $row['EvidenceTitle']; ?>
                            </td>
                            <td>
                                <?php echo $row['Category']; ?>
                            </td>
                            <td>
                                <?php echo $row['Directorate']; ?>
                            </td>
                            <td>
                                <?php echo $row['SectionCell']; ?>
                            </td>
                            <td class="hidden-column">
                                <a href="read.php?viewid=<?php echo htmlentities($row['ID']); ?>" class="view"
                                    title="مشاهدة" data-toggle="tooltip"><img src="view_icon.svg" alt="View Icon"
                                        class="view-icon"></a>
                                <a href="edit.php?editid=<?php echo htmlentities($row['ID']); ?>" class="edit"
                                    title="إضافة" data-toggle="tooltip"><img src="edit_icon.svg" alt="Edit Icon"
                                        class="edit-icon"></a>
                                <a href="index.php?delid=<?php echo ($row['ID']); ?>&&ppic=<?php echo $row['ProfilePic']; ?>"
                                    class="delete" title="حذف" data-toggle="tooltip"
                                    onclick="return confirm('Do you really want to Delete ?');"><img
                                        src="delete_icon.svg" alt="Delete Icon" class="delete-icon"></a>
                            </td>
                        </tr>
                        <?php
                                $cnt = $cnt + 1;
                            }
                        } else { ?>
                        <tr>
                            <th style="text-align:center; color:red;" colspan="6">لا تتوفر سجلات</th>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add a modal for password input -->
    <div id="passwordModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">إدخل الرقم السري</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="password" class="form-control" id="passwordInput" placeholder="كلمة السر">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ألغاء</button>
                    <button type="button" class="btn btn-primary" onclick="checkPassword()">يعتمد</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    function checkPassword() {
        // Retrieve the entered password
        var password = document.getElementById('passwordInput').value;

        // Here you should implement your logic to verify the password
        // For demonstration purposes, I'm just checking if the password is 'password'
        if (password === 'password') {
            // Password is correct, show the hidden column
            var hiddenColumn = document.getElementsByClassName('hidden-column');
            for (var i = 0; i < hiddenColumn.length; i++) {
                hiddenColumn[i].style.display = 'table-cell';
            }
            // Hide the password icon
            document.getElementById('passwordIcon').style.display = 'none';
        } else {
            // Password is incorrect, show an alert
            alert('Incorrect password. Please try again.');
        }
    }
    </script>
</body>

</html>