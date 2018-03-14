<div class='container-fluid'>
    <div class='jumbotron mt-2'>
        <div class='container'>
            <div class="alert alert-success" role="alert">
              Status goes here
            </div>
            <h5 class='hero text-align-center'>SIGNUP</h5>
            <hr class='my-4'>
            <div class='container'>
                <form action='signup-submit' method='POST'>
                    <div class='form-group'>
                        <label for="first">First Name</label>
                        <input class='form-control' type='text' placeholder='First Name' name='first' id='first'>
                        <label for="last">Last Name</label>
                        <input class='form-control' type='text' placeholder='Last Name' name='last' id='last'>
                        <label for="username">Username</label>
                        <input class='form-control' type='text' placeholder='Username' name='username' id='username'>
                        <label for="password">Password</label>
                        <input class='form-control' type='password' placeholder='Password' name='password' id='password'>
                        <label for="type">User Type</label>
                        <select class="form-control" id="type" name='type'>
                          <option>STUDENT</option>
                          <option>TEACHER</option>
                        </select>
                        <div id='additional-form'>
                            <label for="class">Class</label>
                            <select class="form-control" id="class" name='class'>
                                <option>6-BATUMBAKAL</option>
                                <option>6-BATIBOT</option>
                            </select>
                        </div>
                        <div class='container-fluid mt-3'>
                            <button class='btn btn-primary'>SUBMIT</button>
                            <button class='btn btn-secondary'>CANCEL</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#type').click(function(){
       $('#type').change(function(){
          $('#additional-form').toggle(200);
       });
    });
</script>