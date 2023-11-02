

export class Miser{

    constructor(el) {
        this.el = el;
        this.elBody = document.body;
        this.elCover = this.el.closest('[data-js-modal="cover"]');
        this.form;
        this.maxMise;
        this.Id;
    }

    gererFormulaire() {
        this.form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.sendMise(this.form);
        })
    }

    async ouvrirModal(detail) {
        await this.creerFormulaire(detail);
        this.el.classList.remove('non-exist');
        this.elCover.classList.toggle('non-exist');
        this.elBody.classList.toggle('no-scroll');
    }

    fermerMiser() {
        this.el.classList.add('non-exist');
    }

    sendMise() {
        
    }
    
    async creerFormulaire(detail) {
        const reponse = await fetch("/view/templates/miser.html");
        let html = await reponse.text();

        html = html.replaceAll("{{ enchere.max_mise }}", detail.mise);
        html = html.replaceAll("{{ enchere.id }}", detail.id);

        this.el.innerHTML = html;
        this.form = this.el.querySelector('form');

        this.gererFormulaire();
    }
}