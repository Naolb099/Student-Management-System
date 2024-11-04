<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eligibility Determination</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h2>Eligibility Determination</h2>
        <form action="eligibility_form.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="student_name" class="form-label">Student Name</label>
                <input type="text" class="form-control" id="student_name" name="student_name" required>
            </div>
            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" required>
            </div>
            <div class="mb-3">
                <label for="disability" class="form-label">Disability</label>
                <input type="text" class="form-control" id="disability" name="disability" required>
            </div>
            <div class="mb-3">
                <label for="eligibility" class="form-label">Eligibility Status</label>
                <select class="form-select" id="eligibility" name="eligibility" required>
                    <option value="">Select</option>
                    <option value="eligible">Eligible</option>
                    <option value="not_eligible">Not Eligible</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="attachment" class="form-label">Upload Document</label>
                <input type="file" class="form-control" id="attachment" name="attachment" accept="application/pdf">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>