class Quizr_Public_Shortcode_Question_Set {

    constructor( element ) {
        this.element = element;
        this.intro = this.element.querySelector('.quizr-qs-intro');
        this.start_quiz_link = this.element.querySelector('.quizr-qs-intro__start_quiz');
        this.submit_quiz_link = this.element.querySelector('.quizr-qs-results__submit-quiz');
        this.questions = this.element.querySelector('.quizr-qs-questions');
        this.cards = this.questions.children;
        this.arrows_container = this.element.querySelector('.quizr-qs-arrows');
        this.prev_arrow = this.element.querySelector('.quizr-qs-arrows__prev');
        this.next_arrow = this.element.querySelector('.quizr-qs-arrows__next');
        this.pips_container = this.element.querySelector('.quizr-qs-pips');
        this.pips = this.element.querySelectorAll('.quizr-qs-pips__a');
        console.log(this.element);
    }

}