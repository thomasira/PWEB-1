
export class Stamp{
    constructor(el){
        this.el = el;
        this.elImg = this.el.querySelector('[data-js-image]');
        this.init();
    }

    init() {
        this.elImg.addEventListener('click', () => {
            const event = new CustomEvent('ouvrirImage', {detail: this.elImg.src});
            document.dispatchEvent(event);
        })
    }
}