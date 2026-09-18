```php
<?php

session_start();

require_once "config/database.php";
require_once "helpers/helpers.php";

$pageTitle = "Add Student";

$message = "";
$messageType = "";

$name = "";
$email = "";
$phone = "";
$course = "";
$year = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get form data
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $course = trim($_POST["course"] ?? "");
    $year = trim($_POST["year"] ?? "");


    // Name validation
    if ($name === "") {

        $message = "Name is required.";
        $messageType = "danger";

    } elseif (strlen($name) < 2) {

        $message = "Name must contain at least 2 characters.";
        $messageType = "danger";

    } elseif (strlen($name) > 100) {

        $message = "Name cannot be more than 100 characters.";
        $messageType = "danger";
    }


    // Email validation
    elseif ($email === "") {

        $message = "Email is required.";
        $messageType = "danger";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email address.";
        $messageType = "danger";

    } elseif (strlen($email) > 100) {

        $message = "Email cannot be more than 100 characters.";
        $messageType = "danger";
    }


    // Phone validation
    elseif ($phone !== "" && !isValidPhone($phone)) {

        $message = "Phone number must contain exactly 10 digits.";
        $messageType = "danger";
    }


    // Course validation
    elseif ($course === "") {

        $message = "Course is required.";
        $messageType = "danger";

    } elseif (strlen($course) > 100) {

        $message = "Course cannot be more than 100 characters.";
        $messageType = "danger";
    }


    // Year validation
    elseif ($year === "") {

        $message = "Year is required.";
        $messageType = "danger";

    } elseif (!in_array($year, ["First Year", "Second Year", "Third Year", "Final Year"])) {

        $message = "Please select a valid year.";
        $messageType = "danger";
    }


    // Save to database
    else {

        try {

            $sql = "INSERT INTO students
                    (name, email, phone, course, year)
                    VALUES
                    (:name, :email, :phone, :course, :year)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ":name" => $name,
                ":email" => $email,
                ":phone" => $phone,
                ":course" => $course,
                ":year" => $year
            ]);


            $_SESSION["success"] = "Student added successfully!";

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


<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1 class="fw-bold mb-1">
            Add Student
        </h1>

        <p class="text-muted mb-0">
            Add a new student record
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

    <div class="card-body p-4">


        <?php if ($message !== ""): ?>

            <div
                class="alert alert-<?php echo $messageType; ?>"
                role="alert"
            >

                <?php echo htmlspecialchars($message); ?>

            </div>

        <?php endif; ?>


        <form method="POST">


            <!-- Name -->

            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Full Name <span class="text-danger">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    maxlength="100"
                    value="<?php echo htmlspecialchars($name); ?>"
                    placeholder="Enter full name"
                    required
                >

            </div>


            <!-- Email -->

            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Email <span class="text-danger">*</span>
                </label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    maxlength="100"
                    value="<?php echo htmlspecialchars($email); ?>"
                    placeholder="Enter email address"
                    required
                >

            </div>


            <!-- Phone -->

            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Phone
                </label>

                <input
                    type="text"
                    name="phone"
                    class="form-control"
                    maxlength="10"
                    value="<?php echo htmlspecialchars($phone); ?>"
                    placeholder="Enter 10-digit phone number"
                >

                <div class="form-text">
                    Phone number is optional.
                </div>

            </div>


            <!-- Course -->

            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Course <span class="text-danger">*</span>
                </label>

                <input
                    type="text"
                    name="course"
                    class="form-control"
                    maxlength="100"
                    value="<?php echo htmlspecialchars($course); ?>"
                    placeholder="Example: Computer Engineering"
                    required
                >

            </div>


            <!-- Year -->

            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Year <span class="text-danger">*</span>
                </label>

                <select
                    name="year"
                    class="form-select"
                    required
                >

                    <option value="">
                        Select Year
                    </option>

                    <option
                        value="First Year"
                        <?php echo ($year === "First Year") ? "selected" : ""; ?>
                    >
                        First Year
                    </option>

                    <option
                        value="Second Year"
                        <?php echo ($year === "Second Year") ? "selected" : ""; ?>
                    >
                        Second Year
                    </option>

                    <option
                        value="Third Year"
                        <?php echo ($year === "Third Year") ? "selected" : ""; ?>
                    >
                        Third Year
                    </option>

                    <option
                        value="Final Year"
                        <?php echo ($year === "Final Year") ? "selected" : ""; ?>
                    >
                        Final Year
                    </option>

                </select>

            </div>


            <!-- Submit -->

            <button
                type="submit"
                class="btn btn-primary"
            >
                Add Student
            </button>

            <a
                href="students.php"
                class="btn btn-outline-secondary"
            >
                Cancel
            </a>


        </form>

    </div>

</div>


<?php

require_once "includes/footer.php";

?>
```
