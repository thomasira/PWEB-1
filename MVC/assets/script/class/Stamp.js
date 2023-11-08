
export class Stamp{
    constructor(el){
        this.el = el;
        this.elImg = this.el.querySelector('[data-js-image]');
        this.elMise = this.el.querySelector('[data-js-miser]');
        this.data = {
            mise: this.el.querySelector('[data-js-mise]').dataset.jsMise,
            id: this.el.querySelector('[data-js-id]').dataset.jsId,
            membre_id: this.el.dataset.jsMembre
        }
        this.init();
    }

    init() {
        this.elImg.addEventListener('click', () => {
            const event = new CustomEvent('ouvrirImage', {detail: this.elImg.src});
            document.dispatchEvent(event);
        });
        /* this.elMise.addEventListener('click', () => {
            const event = new CustomEvent('ouvrirMise', {detail: this.data});
            document.dispatchEvent(event);
        }); */
    }
}