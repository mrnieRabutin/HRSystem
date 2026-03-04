<!DOCTYPE html>
<html>
<head>
    <title>Assignment Order PDF Generator</title>

<style>
    body {
        font-family: "Segoe UI", sans-serif;
        margin: 0;

        /* ✅ BACKGROUND IMAGE ADDED */
        background: url('images/deped_office.jpg') no-repeat center center fixed;
        background-size: cover;
    }

    /* ===== HEADER STYLE ===== */
    .header {
        background-color: #163c77;
        color: white;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .header-left img {
        width: 55px;
    }

    .header-text {
        line-height: 1.2;
    }

    .header-text small {
        font-size: 12px;
        opacity: 0.9;
    }

    .header-text h1 {
        font-size: 20px;
        margin: 0;
        font-weight: 600;
    }

    .header-right {
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 1px;
    }

    /* ===== FORM WRAPPER ===== */
    .wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 0;
    }

    /* ===== CONTAINER WITH WATERMARK ===== */
    .container {
        position: relative;
        background: #ffffff;
        width: 380px;
        padding: 20px 25px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .container * {
        position: relative;
        z-index: 1;
    }

    h2 {
        text-align: center;
        color: #003366;
        margin-bottom: 15px;
        font-size: 18px;
    }

    label {
        font-weight: 600;
        font-size: 13px;
        color: #333;
    }

    input {
        width: 100%;
        padding: 6px;
        margin-top: 3px;
        margin-bottom: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
        font-size: 13px;
        background: rgba(255,255,255,0.9);
    }

    input:focus {
        border-color: #003366;
        outline: none;
    }

    button {
        width: 100%;
        padding: 8px;
        background-color: #003366;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        transition: 0.3s ease;
    }

    button:hover {
        background-color: #b22222;
    }
</style>
</head>
<body>

<div class="header">
    <div class="header-left">
        <img src="images/deped_logo.jpg" alt="DepEd Logo">
        <div class="header-text">
            <small>Republic of the Philippines</small>
            <h1>Department of Education</h1>
        </div>
    </div>
    <div class="header-right">
        DIVISION OF SOUTHERN LEYTE
    </div>
</div>

<div class="wrapper">
<div class="container">

<h2>Assignment Order Generator</h2>

<form action="generate.php" method="post" target="_blank">

<label>Effective Date:</label>
<input type="date" name="date" required>

<label>Special Order No:</label>
<input type="text" name="so_number" required>

<label>Year:</label>
<input type="text" name="year" required>

<label>Zone:</label>
<input type="text" name="zone" required>

<label>District:</label>
<input type="text" name="district" required>

<label>Appointed As (Position):</label>
<input type="text" name="position" required>

<label>Assigned At (Office):</label>
<input type="text" name="office" required>

<label>Conforme:</label>
<input type="text" name="conforme" placeholder="Signature / Name" required>

<button type="submit" name="generate">Generate PDF</button>

</form>

</div>
</div>

</body>
</html>