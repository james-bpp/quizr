<div class="quizr-admin-answer-container">
    <table class="widefat">
        <thead>
            <tr>
                <th><?php echo __('Description', 'quizr'); ?></th>
                <th><?php echo __( 'Correct', 'quizr'); ?></th>
                <th width="10%"><?php echo __( 'Action', 'quizr'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach( $answers as $index => $value ) { ?>

                <tr>
                    <td>
                        <input name="quizr_description" type="text" value="<?php echo $value->description; ?>" class="widefat" readonly/>
                    </td>
                    <th class="check-column">
                        <input 
                            type="radio"
                            name="quizr_answer_correct"
                            value="<?php echo $index; ?>"
                            <?php checked( (int) $value->is_correct === 1); ?>
                        
                        />
                    </th>
                    <td>
                        <div class="quizr-button-group-flex">
                            <a class="button quizr-answer-edit" href="" >Edit</a>
                            <a class="quizr-answer-delete quizr-button-group-flex--quizr-button-delete" href="" >Delete</a>
                        </div>
                    </td>
                
                </tr>

            <?php } ?>
        </tbody>
    </table>
</div>