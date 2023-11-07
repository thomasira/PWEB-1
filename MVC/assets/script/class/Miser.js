

export class Miser{

    constructor(el) {
        this.el = el;
        this.elBody = document.body;
        this.elCover = this.el.closest('[data-js-modal="cover"]');
        this.form;
        this.maxMise;
        this.Id;
    }

    async creerFormulaire(detail) {
        const reponse = await fetch("/view/templates/miser.html");
        let html = await reponse.text();

        html = html.replaceAll("{{ enchere.max_misePlus }}", parseFloat(detail.mise) + 1);
        html = html.replaceAll("{{ enchere.max_mise }}", detail.mise);
        html = html.replaceAll("{{ enchere.id }}", detail.id);
        html = html.replaceAll("{{ enchere.membre_id }}", detail.membre_id);

        this.el.innerHTML = html;
        this.form = this.el.querySelector('form');

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
}