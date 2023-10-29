
export class BoxImage{
    #el;
    #elTargetBox;

    constructor(el) {
        this.#el = el;
        this.#elTargetBox = document.querySelector('[data-js-box="timbre"]');
        this.#init();
    }

    #init() {
        this.#el.addEventListener('mouseover', (e) => {
            const img = this.#elTargetBox.querySelector('img');

            img.src = this.#el.src;
            this.#elTargetBox.classList.toggle('non-exist');
        });
        this.#el.addEventListener('mouseout', (e) => {
            this.#elTargetBox.classList.toggle('non-exist');
        });
    }
}