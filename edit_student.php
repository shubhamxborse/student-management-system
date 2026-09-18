<?php

session_start();

require_once "config/database.php";

$pageTitle = "Edit Student";

$message = "";
$messageType = "";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("Invalid student ID.");
}

$id = (int) $_GET["id"];

$sql = "SELECT * FROM students WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":id" => $id
]);

$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die("Student not found.");
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $course = trim($_POST["course"] ?? "");
    $year = trim($_POST["year"] ?? "");


    if (
        $name === "" ||
        $email === "" ||
        $course === "" ||
        $year === ""
    ) {

        $message = "Please fill in all required fields.";
        $messageType = "danger";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email address.";
        $messageType = "danger";

    } else {

        try {

            $sql = "UPDATE students
                    SET
                        name = :name,
                        email = :email,
                        phone = :phone,
                        course = :course,
                        year = :year
                    WHERE id = :id";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ":name" => $name,
                ":email" => $email,
                ":phone" => $phone,
                ":course" => $course,
                ":year" => $year,
                ":id" => $id
            ]);

            $message = "Student updated successfully!";
            $messageType = "success";


            $student["name"] = $name;
            $student["email"] = $email;
            $student["phone"] = $phone;
            $student["course"] = $course;
            $student["year"] = $year;

            $_SESSION["success"] = "Student updated successfully!";

            header("Location: students.php");

            exit;

        } catch (PDOException $e) {

            if ($e->getCode() == 23000) {

                $message = "This email address is already registered.";
                $messageType = "danger";

            } else {

                $message = "Something went wrong. Please try again.";
                $messageType = "danger";

            }
        }
    }
}


require_once "includes/header.php";

?>

<div class="row justify-content-center">

    <div class="col-md-8 col-lg-7">


        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h1 class="fw-bold mb-1">
                    Edit Student
                </h1>

                <p class="text-muted mb-0">
                    Update student information
                </p>

            </div>


            <a
                href="students.php"
                class="btn btn-outline-secondary"
            >
                Back
            </a>

        </div>


        <?php if ($message !== ""): ?>

            <div
                class="alert alert-<?php echo $messageType; ?>"
                role="alert"
            >

                <?php echo htmlspecialchars($message); ?>

            </div>

        <?php endif; ?>


        <div class="card shadow-sm border-0">

            <div class="card-body p-4">

                <form method="POST">


                    <div class="mb-3">

                        <label
                            for="name"
                            class="form-label fw-semibold"
                        >
                            Name
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="name"
                            name="name"
                            value="<?php echo htmlspecialchars($student["name"]); ?>"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label
                            for="email"
                            class="form-label fw-semibold"
                        >
                            Email
                        </label>

                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            value="<?php echo htmlspecialchars($student["email"]); ?>"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label
                            for="phone"
                            class="form-label fw-semibold"
                        >
                            Phone
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="phone"
                            name="phone"
                            value="<?php echo htmlspecialchars($student["phone"]); ?>"
                        >

                    </div>


                    <div class="mb-3">

                        <label
                            for="course"
                            class="form-label fw-semibold"
                        >
                            Course
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="course"
                            name="course"
                            value="<?php echo htmlspecialchars($student["course"]); ?>"
                            required
                        >

                    </div>


                    <div class="mb-4">

                        <label
                            for="year"
                            class="form-label fw-semibold"
                        >
                            Year
                        </label>

                        <select
                            class="form-select"
                            id="year"
                            name="year"
                            required
                        >

                            <option value="">
                                Select Year
                            </option>


                            <option
                                value="1st Year"
                                <?php echo $student["year"] === "1st Year" ? "selected" : ""; ?>
                            >
                                1st Year
                            </option>


                            <option
                                value="2nd Year"
                                <?php echo $student["year"] === "2nd Year" ? "selected" : ""; ?>
                            >
                                2nd Year
                            </option>


                            <option
                                value="3rd Year"
                                <?php echo $student["year"] === "3rd Year" ? "selected" : ""; ?>
                            >
                                3rd Year
                            </option>


                            <option
                                value="4th Year"
                                <?php echo $student["year"] === "4th Year" ? "selected" : ""; ?>
                            >
                                4th Year
                            </option>

                        </select>

                    </div>


                    <div class="d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Update Student
                        </button>


                        <a
                            href="students.php"
                            class="btn btn-light"
                        >
                            Cancel
                        </a>

                    </div>


                </form>

            </div>

        </div>

    </div>

</div>


<?php

require_once "includes/footer.php";

?>