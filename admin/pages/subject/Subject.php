<?php

const subjectQueryStmt = "CALL proc_subject_getAll";
$subjects = mysqli_query($conn, subjectQueryStmt);
while (mysqli_next_result($conn)) {;
}
?>

<div class="page-title">
    <h2>Danh sách môn học</h2>
</div>

<div class="page-content page-subject">
    <div class="main-content">

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Mã môn</th>
                        <th>Tên môn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($subjects) {
                        while ($subject = mysqli_fetch_array($subjects)) {
                    ?>
                            <tr>
                                <td><?php echo $subject["subjectCode"] ?></td>
                                <td><?php echo $subject["name"] ?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>