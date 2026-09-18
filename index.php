<?php

require_once "config/database.php";

$pageTitle = "Dashboard";

$sql = "SELECT COUNT(*) FROM students";

$stmt = $pdo->query($sql);

$totalStudents = $stmt->fetchColumn();

require_once "includes/header.php";

?>

<div class="mb-4">

    <h1 class="fw-bold">
        Dashboard
    </h1>

    <p class="text-muted">
        Welcome to the Student Management System
    </p>

</div>


<div class="row g-4">


    <!-- Total Students -->

    <div class="col-md-6 col-lg-4">

        <div class="card shadow-sm border-0 h-100">

            <div class="card-body">

                <p class="text-muted mb-2">
                    Total Students
                </p>

                <h2 class="fw-bold mb-3">
                    <?php echo $totalStudents; ?>
                </h2>

                <a
                    href="students.php"
                    class="btn btn-outline-primary btn-sm"
                >
                    View Students
                </a>

            </div>

        </div>

    </div>


    <!-- Add Student -->

    <div class="col-md-6 col-lg-4">

        <div class="card shadow-sm border-0 h-100">

            <div class="card-body">

                <p class="text-muted mb-2">
                    Student Records
                </p>

                <h2 class="fw-bold mb-3">
                    Manage
                </h2>

                <a
                    href="add_student.php"
                    class="btn btn-primary btn-sm"
                >
                    + Add Student
                </a>

            </div>

        </div>

    </div>


</div>


<div class="card shadow-sm border-0 mt-4">

    <div class="card-body p-4">

        <h4 class="fw-bold">
            Quick Actions
        </h4>

        <p class="text-muted">
            Use the options below to manage student records.
        </p>

        <div class="d-flex gap-2">

            <a
                href="students.php"
                class="btn btn-dark"
            >
                View All Students
            </a>

            <a
                href="add_student.php"
                class="btn btn-primary"
            >
                Add New Student
            </a>

        </div>

    </div>

</div>


<?php

require_once "includes/footer.php";

?>