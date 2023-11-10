
export class Boxfilter{
    #el;
    #elForm;
    #elFormOpen;
    #elFormReset;

    constructor(el){
        if (!Boxfilter.instance) Boxfilter.instance = this;
        else throw new Error("impossible de dupliquer cette classe");

        this.#el = el;
        this.#elFormOpen = this.#el.querySelector('[data-js-trigger="open-filtre"]');
        this.#elForm = this.#el.querySelector('form');
        this.#elFormReset = this.#elForm.querySelector('[data-js-trigger="reset"]')

        this.#init();
    }

    #init() {
        this.#elFormOpen.addEventListener('click', () => this.#toggleBoxFilter());

    }

    #toggleBoxFilter() {
        this.#elForm.classList.toggle('non-exist');
        this.#elFormOpen.classList.toggle('inverse');
    }
}

