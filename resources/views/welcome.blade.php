<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appeal Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid">
        <div class="container">
            <div class="card mt-5">
                <div class="card-header fw-bold">
                    Appeal Form
                </div>
                <div class="card-body">
                    <form id="send_appeal">
                        <div class="mb-3">
                            <label for="first_name" class="form-label fw-bold">First Name</label>
                            <input type="text" class="form-control" id="first_name">
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label fw-bold">Last Name</label>
                            <input type="text" class="form-control" id="last_name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">E-Mail</label>
                            <input type="email" class="form-control" id="email">
                        </div>
                        <div class="mb-3">
                            <label for="language" class="form-label fw-bold">Language</label>
                            <select id="language_codes" class="form-select" aria-label="Default select example">
                                <option value="0" selected>Language</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="referances_id" class="form-label fw-bold">Referance</label>
                            <select id="referances_id" class="form-select" aria-label="Default select example">
                                <option value="0" selected>Referance</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label fw-bold">Country / Phone Code / Number</label>
                            <div class="input-group mb-3">
                                <select id="country" class="form-select" aria-label="Default select example">
                                    <option value="0" selected>Country</option>
                                </select>
                                <input type="text" class="form-control" placeholder="+..." id="phone_codes">
                                <input type="number" class="form-control" placeholder="Phone Number" id="phone_number">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label fw-bold">Message</label>
                            <textarea class="form-control" id="message" rows="3"></textarea>
                        </div>
                        <div class="mb-3 text-center">
                            <label class="form-label fw-bold status"></label>
                        </div>
                        <div class="col text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-3">
                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <a href="{{route("appeal.order")}}?data=referance" target="_blank"><button type="button" class="btn btn-danger">Referanslara Göre Listele</button></a>
                    <a href="{{route("appeal.order")}}?data=language" target="_blank"><button href="#" type="button" class="btn btn-warning">Kullanıcı Dillerine Göre Listele</button></a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script>
        $(function() {
            $.get("api/v1/country_code", function(data, status) {
                data.forEach(element => {
                    $("#language_codes").append(`<option value="${element.id}">${element.name} </option>`);
                    $("#country").append(`<option value="${element.id}">${element.code} - ${element.name} </option>`);
                });
            });
            $.get("api/v1/referance", function(data, status) {
                data.forEach(element => {
                    $("#referances_id").append(`<option value="${element.id}">${element.name}</option>`);
                });
            });
            $("#send_appeal").submit(function(event) {
                let data = {
                    first_name: $("#first_name").val(),
                    last_name: $("#last_name").val(),
                    email: $("#email").val(),
                    language_codes: $("#language_codes").val(),
                    phone_number: $("#phone_number").val(),
                    phone_codes: $("#phone_codes").val(),
                    message: $("#message").val(),
                    country: $("#country").val(),
                    referances_id: $("#referances_id").val(),
                }
                $.post("api/v1/appeal", data, function(data, status) {
                    $("#first_name , #last_name ,#email, #message , #phone_number, #phone_codes").val(null);
                    $("#language_codes , #country").val(0).prop("selected", true).change();
                    $(".status").html(`<div class="p-2 mb-2 bg-success text-white">Registration Successful</div>`);
                    setTimeout(function() {
                        $(".status").html(null);
                    }, 1500);
                }).fail(function(xhr, status, error) {
                    $(".status").html(`<div class="p-2 mb-2 bg-danger  text-white">Registration failed.</div>`);
                    if (xhr.status == 422) {
                        Object.entries(xhr.responseJSON).forEach(([key, value]) => {
                            $(".status").append(`<div class="p-1 mb-1 bg-warning text-white">${value[0]}</div>`);
                        });
                    } else {
                        $(".status").append(`<div class="p-1 mb-1 bg-warning text-white">${xhr.responseJSON}</div>`);
                    }
                    setTimeout(function() {
                        $(".status").html(null);
                    }, 4000);
                });
                event.preventDefault();
            });
        });
    </script>
</body>

</html>