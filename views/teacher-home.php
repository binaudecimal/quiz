<div class='container-fluid'>
    <div class='jumbotron h-100'>
        <div class='row justify-content-center'>
            <div class='container'>
                <div class="alert alert-success" role="alert">
                      Status goes here
                </div>
            </div>
        </div>
        <div class='container-fluid'>
            
            
            <div class='container-fluid w-25 h-100 float-left' style='bg-color:#efefef;'>
                <div class='row h-50 w-100'>
                    <div class='container-fluid h-100 w-100'>
                        <h5 class='display-5'>Sidebar</h5>
                        <div class='list-group'>
                            <a href="#" class="list-group-item list-group-item-action active" data-toggle="modal" data-target="#liveModal" role="button" id='live-modal-toggle'>Start a Quiz?</a>
                            <a href="#" class="list-group-item list-group-item-action">Class 2 Graphs</a>
                            <a href="#" class="list-group-item list-group-item-action">Question Analysis</a>
                            <a href="#" class="list-group-item list-group-item-action">Student Statistics</a>
                        </div>
                    </div>
                </div>
                <div class='row h-50 w-100'>
                    <div class='row h-50 w-100'>
                        <div class='container-fluid h-100'>
                            <div class='card'>
                                <div class='card-header'>
                                    Chats
                                </div>
                                <div class='card-body'>
                                    <div class='container-fluid'>
                                        <!-- chat contents here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class='row h-50 w-100'>
                        <div class='container-fluid h-100'>
                            <div class='card'>
                                <div class='card-header'>
                                    Logs
                                </div>
                                <div class='card-body'>
                                    <div class='container-fluid'>
                                        <!-- logs contents here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class='container w-75 h-100 float-left bg-light pt-3 pb-3'>
                <div class='card'>
                    <div class='card-header'>
                        Issue # 100
                    </div>
                    <div class='card-body'>
                        <p class='card-text'>
                            Issue on {xxx} submitted by {someone}
                        </p>
                        <a class='btn btn-primary' role='btn' href='#'>Mark as resolved</a>
                    </div>
                </div>
                
                <div class='card'>
                    <div class='card-header'>
                        Issue # 101
                    </div>
                    <div class='card-body'>
                        <p class='card-text'>
                            Issue on {xxx1} submitted by {someone1}
                        </p>
                        <a class='btn btn-primary' role='btn' href='#'>Mark as resolved</a>
                    </div>
                </div>
                
                <div class='card'>
                    <div class='card-header'>
                        Issue # 100
                    </div>
                    <div class='card-body'>
                        <p class='card-text'>
                            Issue on {xxx2} submitted by {someone2}
                        </p>
                        <a class='btn btn-primary' role='btn' href='#'>Mark as resolved</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
     
    
    <!-- bottom nav-bar-->
    <nav class='navbar fixed-bottom navbar-light bg-light navbar-expand-lg'>
        <ul class='navbar-nav mr-auto'>
            <li class='nav-item'>
                <a class='nav-link' href='#'>
                    Toggle Sidebar
                </a>
            </li>
        </ul>
        <ul class='navbar-nav ml-auto'>
            <li class='nav-item'>
                <a class='nav-link' href='add-question'>Add Question</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='edit-question'>Edit Question</a>
            </li>
        </ul>
    </nav>
</div>

<!--popup sections -->

<div class='modal fade' id='liveModal'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">You are about to activate a quiz...</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class='modal-content'>
                <div class='container'>
                    <div class='form-group'>
                        <form>
                            <label for='quiz-section'>Section</label>
                            <select class="form-control" id="quiz-section" name='section'>
                                <option value='class1'>6-BATIBOT</option>
                                <option value='class1'>6-SESAME</option>
                            </select>
                            
                            <label for="region">Region</label>
                            <select class="form-control" id="region" name='region'>
                                <option value='ncr'>National Capital Region (NCR)</option>
                                <option value='region1'>Ilocos Region (Region 1)</option>
                                <option value='car'>Cordillera Administrative Region (CAR)</option>
                                <option value='region2'>Cagayan Valley (Region 2)</option>
                                <option value='region3'>Central Luzon (Region 3)</option>
                                <option value='region4a'>CALABARZON (Region 4A)</option>
                                <option value='mimaropa'>Southwestern Tagalog Region (MIMAROPA)</option>
                                <option value='region5'>Bicol Region (Region 5)</option>
                                <option value='region6'>Western Visayas (Region 6)</option>
                                <option value='region7'>Central Visayas (Region 7)</option>
                                <option value='region8'>Eastern Visayas (Region 8)</option>
                                <option value='region9'>Zamboanga Peninsula (Region 9)</option>
                                <option value='region10'>Northern Mindanao (Region 10)</option>
                                <option value='region11'>Davao Region (Region 11)</option>
                                <option value='region12'>SOCCSLSARGEN (Region 12)</option>
                                <option value='region13'>Caraga Region (Region 13)</option>
                                <option value='armm'>Autonomous Region in Muslim Mindanao (ARMM)</option>
                            </select>
                            
                            <label for='quiz-duration'>Question Duration (seconds)</label>
                            <input class='form-control' value='10' name='duration' id='quiz_duration'>

                            <label for='quiz-items'>Items</label>
                            <input class='form-control' value='10' name='duration' id='quiz_items'>
                            <div class='container-fluid mt-3'>
                                <button class='btn btn-primary'>Quiz Activate!</button>
                                <button class='btn btn-secondary' data-dismiss='modal' aria-label='Cancel'>Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    /*
    $('#live-modal-toggle').click(function(){
        $('#live-modal-text').append('I am clicked!');
    });
    */
</script>