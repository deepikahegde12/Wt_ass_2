
<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
    exit;
}

function clean($value) {
    return trim($value ?? "");
}

function safe($value) {
    return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
}

$name = clean($_POST["name"] ?? "");
$email = clean($_POST["email"] ?? "");
$phone = clean($_POST["phone"] ?? "");
$dob = clean($_POST["dob"] ?? "");
$gender = clean($_POST["gender"] ?? "");
$course = clean($_POST["course"] ?? "");
$address = clean($_POST["address"] ?? "");
$declaration = $_POST["declaration"] ?? "";

$errors = [];

if ($name === "" || $address === "") {
    $errors[] = "Name and address are required.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
}

if (!preg_match("/^[0-9]{10}$/", $phone)) {
    $errors[] = "Phone number must contain 10 digits.";
}

$date = DateTime::createFromFormat("!Y-m-d", $dob);
if (!$date || $date->format("Y-m-d") !== $dob ||
    $date > new DateTime("today")) {
    $errors[] = "Please enter a valid date of birth.";
}

if (!in_array($gender, ["Female", "Male", "Other"], true)) {
    $errors[] = "Please select a valid gender.";
}

$allowedCourses = [
    "Computer Science Engineering",
    "Information Science Engineering",
    "Electronics and Communication",
    "Mechanical Engineering",
    "Civil Engineering"
];

if (!in_array($course, $allowedCourses, true)) {
    $errors[] = "Please select a valid course.";
}

if ($declaration !== "yes") {
    $errors[] = "Please accept the declaration.";
}

if ($errors) {
    http_response_code(400);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Result</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Student Registration</h1>
    <p>Online Application Portal</p>
</header>

<main class="container">
    <section class="form-card">

        <?php if ($errors): ?>

            <div class="form-heading">
                <h2>Registration Unsuccessful</h2>
                <p>Please correct the following errors:</p>
            </div>

            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= safe($error) ?></li>
                <?php endforeach; ?>
            </ul>

            <a class="action-link" href="index.html">
                Return to Form
            </a>

        <?php else: ?>

            <div class="form-heading">
                <span class="tag">SUBMISSION SUCCESSFUL</span>
                <h2>Registration Completed!</h2>
                <p>Your application details are displayed below.</p>
            </div>

            <div class="result-card">
                <h3>Applicant Information</h3>

                <div class="result-row">
                    <strong>Full Name</strong>
                    <span><?= safe($name) ?></span>
                </div>

                <div class="result-row">
                    <strong>Email Address</strong>
                    <span><?= safe($email) ?></span>
                </div>

                <div class="result-row">
                    <strong>Phone Number</strong>
                    <span><?= safe($phone) ?></span>
                </div>

                <div class="result-row">
                    <strong>Date of Birth</strong>
                    <span><?= safe($dob) ?></span>
                </div>

                <div class="result-row">
                    <strong>Gender</strong>
                    <span><?= safe($gender) ?></span>
                </div>

                <div class="result-row">
                    <strong>Course</strong>
                    <span><?= safe($course) ?></span>
                </div>

                <div class="result-row">
                    <strong>Address</strong>
                    <span><?= nl2br(safe($address)) ?></span>
                </div>
            </div>

            <p class="success-note">
                Thank you for submitting your application.
            </p>

            <a class="action-link" href="index.html">
                Back to Home
            </a>

            <button type="button" onclick="window.print()">
                Print Application
            </button>

        <?php endif; ?>

    </section>
</main>

<footer>
    <p>&copy; <?= date("Y") ?> Student Registration Portal</p>
</footer>

</body>
</html>
