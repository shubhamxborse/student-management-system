<?php

require_once "config/database.php";

$pageTitle = "View Student";

$id = $_GET["id"] ?? "";

if (!ctype_digit($id)) {

    die("Invalid student ID.");

}

$sql = "SELECT * FROM students WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":id" => $id
]);

$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {

    die("Student not found.");

}

require_once "includes/header.php";

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1 class="fw-bold mb-1">
            Student Details
        </h1>

        <p class="text-muted mb-0">
            View complete student information
        </p>

    </div>

    <a
        href="students.php"
        class="btn btn-outline-dark"
    >
        ← Back to Students
    </a>

</div>


<div class="card shadow-sm border-0">

    <div class="card-header bg-dark text-white">

        <h5 class="mb-0">
            Student #<?php echo $student["id"]; ?>
        </h5>

    </div>

    <div class="card-body p-4">

        <div class="row g-4">

            <div class="col-md-6">

                <label class="text-muted small">
                    Full Name
                </label>

                <h5 class="fw-semibold">
                    <?php echo htmlspecialchars($student["name"]); ?>
                </h5>

            </div>


            <div class="col-md-6">

                <label class="text-muted small">
                    Email
                </label>

                <h5 class="fw-semibold">
                    <?php echo htmlspecialchars($student["email"]); ?>
                </h5>

            </div>


            <div class="col-md-6">

                <label class="text-muted small">
                    Phone
                </label>

                <h5 class="fw-semibold">

                    <?php

                    if (!empty($student["phone"])) {
                        echo htmlspecialchars($student["phone"]);
                    } else {
                        echo "-";
                    }

                    ?>

                </h5>

            </div>


            <div class="col-md-6">

                <label class="text-muted small">
                    Course
                </label>

                <h5 class="fw-semibold">
                    <?php echo htmlspecialchars($student["course"]); ?>
                </h5>

            </div>


            <div class="col-md-6">

                <label class="text-muted small">
                    Year
                </label>

                <h5 class="fw-semibold">
                    <?php echo htmlspecialchars($student["year"]); ?>
                </h5>

            </div>


            <div class="col-md-6">

                <label class="text-muted small">
                    Created At
                </label>

                <h5 class="fw-semibold">
                    <?php echo htmlspecialchars($student["created_at"]); ?>
                </h5>

            </div>

        </div>


        <hr class="my-4">


        <div class="d-flex gap-2">

            <a
                href="edit_student.php?id=<?php echo $student["id"]; ?>"
                class="btn btn-primary"
            >
                Edit Student
            </a>

            <a
                href="delete_student.php?id=<?php echo $student["id"]; ?>"
                class="btn btn-danger"
                onclick="return confirm('Are you sure you want to delete this student?');"
            >
                Delete Student
            </a>

        </div>

    </div>

</div>


<?php

require_once "includes/footer.php";

?>