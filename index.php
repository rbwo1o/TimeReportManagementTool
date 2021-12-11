<?php
# TempTimeline by Blaine Wilson

# require all dependencies
    require_once 'config.php';

# start php session
    session_start();
    /* -- Session Variables used -- 
    
    $_SESSION['auth'] - used to check user authentication
    $_SESSION['access_level'] - used to check the access privilege of a user
    $_SESSION['name'] - used to get the name of a user
    $_SESSION['email'] - used to get the email of a user
    $_SESSION['id] - used to get the id of a user
    
    $_SESSION['generate_report'] - required before generating a report.
    $_SESSION['mail_preview'] - required before mailing the report preview

    $_SESSION['edit_user'] - used to validate that a user has been successfully edited
    $_SESSION['created_user'] - used to validate that a user has been successfully created
    $_SESSION['deleted_user'] - used to validate that a user has been successfully deleted
    $_SESSION['updated_timesheet'] - used to validate that a timesheet has successfully been edited

    $_SESSION['reset_password'] - used to validate that a password reset message has successfully been emailed

    */


# Require Auth
    Flight::route('*', function(){
        if(empty($_SESSION['auth'])){
            Flight::render('log_in');
        }
        else{
            return true;
        }
    });



# Default User Routes
    Flight::route('/', function(){
        if($_SESSION['access_level'] == 2){
            Flight::render('report');
        }
        else{
            Flight::render('current_timesheet');
        }
    });


    Flight::route('/settings', function(){
        Flight::render('settings');
    });


    Flight::route('/history', function(){
        if($_SESSION['access_level'] == 2){
            echo "404";
        }
        else{
            Flight::render('history');
        }
    });


    # Current Timesheet
    Flight::route('/current_timesheet', function(){
        Flight::render('current_timesheet');
    });
    Flight::route('/timesheet', function(){
        Flight::render('current_timesheet');
    });



# Administrative Routes 
    Flight::route('/report', function(){
        if($_SESSION['access_level'] == "1"){
            echo "error 404";
        }
        else{
            Flight::render('report');
        }
    });


    Flight::route('/report_history', function(){
        if($_SESSION['access_level'] == 1){
            echo "404";
        }
        else{
            Flight::render('report_history');
        }
    });


    Flight::route('/accounts', function(){
        if($_SESSION['access_level'] == 1){
            echo "404";
        }
        else{
            Flight::render('user_accounts');
        }
    });


    Flight::route('/user_accounts', function(){
        if($_SESSION['access_level'] == "1"){
            echo "404";
            return;
        }
        else{
            Flight::render('user_accounts');
        }
    
    });



    # -- ADMIN SCRIPTS --
    Flight::route('/generate_report', function(){
        if($_SESSION['access_level'] == 1){
            echo "404";
        }
        else{
            Flight::render('generate_report');
        }
    });


    Flight::route('/delete/@email/@access_level/@id', function($email, $access_level, $id){
        if($_SESSION['access_level'] == 1){
            echo "404";
        }
        else{
            if(Database::delete_user($email, $access_level, $id)){
                echo "Deleted " . $email;
                if($_SESSION['email'] == $email){
                    Flight::redirect("/logout");
                }
                else{
                    $_SESSION['deleted_user'] = $email;
                    Flight::redirect("/user_accounts");
                }
            }
            else{
                $_SESSION['deleted_user'] = $email;
                Flight::redirect("/user_accounts");
            }
        }
    });


    Flight::route('/edit/@old_user/@email/@password/@name/@access_level', function($old_user, $email, $password, $name, $access_level){
        if($_SESSION['access_level'] == 1){
            echo "404";
        }
        else{
            if(Database::edit_user($old_user, $email, $password, $name, $access_level)){
                if($_SESSION['email'] == $old_user){
                    Flight::redirect("/logout");
                }
                else{
                    $_SESSION['edit_user'] = $email;
                    Flight::redirect("/user_accounts");
                }
            }
            else{
                echo "Error Editing " . $email;
            }
        }
    });


    Flight::route('/download_report/@report_id', function($report_id){
        if($_SESSION['access_level'] == 1){
            echo "404";
        }
        else{
            Flight::render('download_report', ['report_id' => $report_id]);
        }
    });


    Flight::route('/delete_report/@report_id', function($report_id){
        if($_SESSION['access_level'] == 1){
            echo "404";
        }
        else{
            Database::delete_report($report_id);
            $_SESSION['deleted_report'] = $report_id;
            Flight::redirect("/report_history");
        }
    });


    Flight::route('/update_timesheet/@id', function($id){
        if($_SESSION['access_level'] == 1){
            echo "404";
        }
        else{
            Flight::render('update_timesheet', ['id' => $id]);
        }
        
    });


    Flight::route('/mail_preview', function(){
        if($_SESSION['access_level'] == 1){
            echo "404";
        }
        else{
            Flight::render('mail_preview');
        }
    });



# Login / Logout
    Flight::route('/login', function(){
        if($_SESSION['auth']){
            Flight::redirect("/");
        }
        else{
            Flight::redirect("/login");
        }
    });


    Flight::route('/logout', function(){
        $_SESSION['auth'] = null;
        $_SESSION['email'] = null;
        $_SESSION['name'] = null;
        $_SESSION['access_level'] = null;
        $_SESSION['id'] = null;
        Flight::redirect("/login");
    });



# Not Found
    Flight::map('notFound', function(){
        echo "Error 404..";
    });



Flight::start();
?>
