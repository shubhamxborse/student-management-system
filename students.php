```php
<?php

require_once "config/database.php";
require_once "helpers/helpers.php";

$pageTitle = "Students";

$search = trim($_GET["search"] ?? "");

if ($search !== "") {

    $sql = "SELECT * FROM students
            WHERE name LIKE :search
               OR email LIKE :search
               OR course LIKE :search
            ORDER BY id DESC";

    $stmt = $pdo->prepare($sql);

    $searchTerm = "%" . $search . "%";

    $stmt->execute([
        ":search" => $searchTerm
    ]);

} else {

    $sql = "SELECT * FROM students ORDER BY id DESC";

    $stmt = $pdo->query($sql);
}

$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once "includes/header.php";

?>

<?php if (isset($_SESSION["success"])): ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">

        <?php echo htmlspecialchars($_SESSION["success"]); ?>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        ></button>

    </div>

    <?php unset($_SESSION["success"]); ?>

<?php endif; ?>


<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1 class="fw-bold mb-1">
            Students
        </h1>

        <p class="text-muted mb-0">
            Manage all student records
        </p>

    </div>

    <a
        href="add_student.php"
        class="btn btn-primary"
    >
        + Add Student
    </a>

</div>


<!-- Search -->

<div class="card shadow-sm border-0 mb-4">

    <div class="card-body">

        <form
            method="GET"
            action="students.php"
            class="row g-2"
        >

            <div class="col-md-8">

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search by name, email or course..."
                    value="<?php echo htmlspecialchars($search); ?>"
                >

            </div>

            <div class="col-md-2">

                <button
                    type="submit"
                    class="btn btn-dark w-100"
                >
                    Search
                </button>

            </div>

            <div class="col-md-2">

                <a
                    href="students.php"
                    class="btn btn-outline-secondary w-100"
                >
                    Clear
                </a>

            </div>

        </form>

    </div>

</div>


<!-- Students Table -->

<div class="card shadow-sm border-0">

    <div class="card-header bg-dark text-white">

        <div class="d-flex justify-content-between align-items-center">

            <span class="fw-bold">
                Student Records
            </span>

            <span>
                <?php echo count($students); ?> record(s)
            </span>

        </div>

    </div>

    <div class="card-body p-0">

        <?php if (count($students) > 0): ?>

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead class="table-light">

                        <tr>

                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Course</th>
                            <th>Year</th>
                            <th>Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach ($students as $student): ?>

                            <tr>

                                <td>
                                    <?php echo $student["id"]; ?>
                                </td>

                                <td class="fw-semibold">
                                    <?php echo clean($student["name"]); ?>
                                </td>

                                <td>
                                    <?php echo clean($student["email"]); ?>
                                </td>

                                <td>
                                    <?php clean($student["phone"] ?: "-"); ?>
                                </td>

                                <td>
                                    <?php echo clean($student["course"]); ?>
                                </td>

                                <td>
                                    <?php echo clean($student["year"]); ?>
                                </td>

                                <td>

                                    <a
                                        href="view_student.php?id=<?php echo $student["id"]; ?>"
                                        class="btn btn-sm btn-outline-dark"
                                    >
                                        View
                                    </a>

                                    <a
                                        href="edit_student.php?id=<?php echo $student["id"]; ?>"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        Edit
                                    </a>

                                    <a
                                        href="delete_student.php?id=<?php echo $student["id"]; ?>"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure you want to delete this student?');"
                                    >
                                        Delete
                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php else: ?>

            <div class="text-center p-5">

                <h5 class="fw-bold">
                    No students found
                </h5>

                <p class="text-muted">

                    <?php

                    if ($search !== "") {

                        echo "No students match your search.";

                    } else {

                        echo "There are no student records yet.";

                    }

                    ?>

                </p>


                <?php if ($search !== ""): ?>

                    <a
                        href="students.php"
                        class="btn btn-outline-dark"
                    >
                        View All Students
                    </a>

                <?php else: ?>

                    <a
                        href="add_student.php"
                        class="btn btn-primary"
                    >
                        + Add First Student
                    </a>

                <?php endif; ?>

            </div>

        <?php endif; ?>

    </div>

</div>


<?php

require_once "includes/footer.php";

?>
```
