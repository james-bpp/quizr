<div class="quizr-qs">         
    <div class="quizr-qs-intro quizr-qs-hide quizr-qs-show--block">
        <article class="quizr-qs-card"> 
            <div class="quizr-qs-card__container">
                <aside class="quizr-qs-card__sidebar">
                    <img class="quizr-qs-card__img" src="https://www.wp-plugins.dev.cc/wp-content/uploads/2021/05/quizr-logo.png" />   
                </aside>   
                <div class="quizr-qs-card__content">
                    <header> 
                        <h2>Time for a Quizr</h2>
                    </header> 
                    <section>
                        <h3>Subject: <?php echo $question_set->post_title; ?></h3>
                        <p>You will be shown some multiple choice questions</p>  
                        <ul>
                            <li>You can move backwards and forwards amongst the questions</li>
                            <li>At the end you will see a summary of your answers</li>
                            <li>After submitting your answers, you will get your score</li>
                        </ul>
                    </section>    
                </div>
                <div class="quizr-qs-card__answers">
                    <div class="quizr-qs-card__answer-label">
                        <p>When you hover over the card, the answers are revealed here!</p>
                    </div>
                </div>
            </div>
            <a class="quizr-qs-intro__start-quiz" href="">START QUIZ</a>
        </article>
    </div>
    <form class="quizr-form" data-id="<?php echo $qs_id; ?>">
        <div class="quizr-qs-questions quizr-qs-hide quizr-qs-show--block">
            <?php foreach( $questions as $key => $q ) { ?>
                <article class="quizr-qs-card"> 
                    <div class="quizr-qs-card__container">
                        <aside class="quizr-qs-card__sidebar">
                            <img class="quizr-qs-card__img" src="https://www.wp-plugins.dev.cc/wp-content/uploads/2021/05/quizr-logo.png" />   
                        </aside>   
                        <div class="quizr-qs-card__content">
                            <header> 
                                <h2>Question <?php echo $key + 1; ?></h2>
                            </header> 
                            <section>
                                <h3><?php echo $q->post_title; ?></h3>
                                <?php echo apply_filters( 'the_content', $q->post_content); ?>
                            </section>    
                        </div>
                        <div class="quizr-qs-card__answers">
                            <?php foreach( $q->answers as $value ) { ?>
                                <div>
                                    <label class="quizr-qs-card__answer-label">
                                        <input
                                            type="radio"
                                            name="quizr"
                                            value="<?php echo esc_html( $value->id ); ?>"
                                        />
                                        <?php echo $value->description; ?>
                                    </label>

                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <a class="quizr-qs-intro__start-quiz" href="">START QUIZ</a>
                </article>

            <?php } ?>
        </div>
    </form>
    
</div>