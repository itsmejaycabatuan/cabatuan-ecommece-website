<?php 
include 'helpers/functions.php'; 
template('header.php');

use Aries\MiniFrameworkStore\Models\User;
use Carbon\Carbon;

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $birthdate = $_POST['birthdate'] ?? null;

    $userModel = new User();
    $userModel->update([
        'id' => $_SESSION['user']['id'],
        'name' => $name,
        'email' => $email,
        'address' => $address,
        'phone' => $phone,
        'birthdate' => $birthdate ? Carbon::createFromFormat('Y-m-d', $birthdate)->format('Y-m-d') : null
    ]);

    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['email'] = $email;
    $_SESSION['user']['address'] = $address;
    $_SESSION['user']['phone'] = $phone;
    $_SESSION['user']['birthdate'] = $birthdate;

    echo "<script>alert('Account details updated successfully!');</script>";
}
?>

<style>
    body {
        background: linear-gradient(to right, #2c2c2c, #3e3e3e);
        color: #f0f0f0;
        font-family: 'Segoe UI', sans-serif;
        min-height: 100vh;
    }

    h1, h2 {
        color: #ffffff;
    }

    .card-form {
        background-color: #1f1f1f;
        padding: 2.5rem;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.6);
    }

    .form-label {
        color: #cccccc;
    }

    .form-control {
        background-color: #2c2c2c;
        color: #f0f0f0;
        border: 1px solid #555;
    }

    .form-control:focus {
        border-color: #888;
        background-color: #2c2c2c;
        color: #fff;
        box-shadow: none;
    }

    .btn-primary {
        background-color: #607d8b;
        border: none;
    }

    .btn-primary:hover {
        background-color: #455a64;
    }

    .btn-danger {
        background-color: #d32f2f;
        border: none;
    }

    .btn-danger:hover {
        background-color: #b71c1c;
    }
</style>

<div class="container py-5">
    <div class="row">
        <div class="col-md-4 mb-4">
            <h1>My Account</h1>
            <p>Welcome, <strong><?php echo $_SESSION['user']['name']; ?></strong></p>
            <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
        </div>
        <div class="col-md-8">
            <div class="card-form">
                <h2 class="mb-4">Edit Account Details</h2>
                <form action="my-account.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required 
                               value="<?php echo htmlspecialchars($_SESSION['user']['name']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required 
                               value="<?php echo htmlspecialchars($_SESSION['user']['email']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" 
                               value="<?php echo htmlspecialchars($_SESSION['user']['address'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" 
                               value="<?php echo htmlspecialchars($_SESSION['user']['phone'] ?? ''); ?>">
                    </div>
                    <div class="mb-4">
                        <label for="birthdate" class="form-label">Birthdate</label>
                        <input type="date" class="form-control" id="birthdate" name="birthdate" 
                               value="<?php echo htmlspecialchars($_SESSION['user']['birthdate'] ?? ''); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="submit">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

