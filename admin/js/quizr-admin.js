window.addEventListener( 'load', function(){

    const quizr_admin_answer_container_el = document.querySelector('.quizr-admin-answer-container');

    if( quizr_admin_answer_container_el != null){
        new Quizr_Admin_Answers( quizr_admin_answer_container_el );
    }

});

