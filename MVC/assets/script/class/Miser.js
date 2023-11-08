

export class Miser{

    constructor() {
        this.elBody = document.body;
        this.elCover = document.querySelector('[data-js-modal="cover"]');
        this.elBox = document.querySelector('[data-js-modal="mise"]');
        this.form;
        this.maxMise;
        this.Id;
        this.buttonsMise = document.querySelectorAll('[data-js-miser]');
        this.init();
    }

    init() {
        this.buttonsMise.forEach(button => {
            button.addEventListener('click', () => {
                const data = {
                    mise: button.dataset.jsMise,
                    id: button.dataset.jsId,
                    membre_id: button.dataset.jsMembre
                }
                this.ouvrirModal(data);
            })
        });
        this.elCover.addEventListener('click', (e) => {
            if(!e.target.closest('article')) this.fermerMiser(); 
        })
    }

    async creerFormulaire(detail) {
        const reponse = await fetch("/view/templates/miser.html");
        let html = await reponse.text();

        html = html.replaceAll("{{ enchere.max_misePlus }}", parseFloat(detail.mise) + 1);
        html = html.replaceAll("{{ enchere.max_mise }}", detail.mise);
        html = html.replaceAll("{{ enchere.id }}", detail.id);
        html = html.replaceAll("{{ enchere.membre_id }}", detail.membre_id);

        this.elBox.innerHTML = html;
        this.form = this.elBox.querySelector('form');

    }

    async ouvrirModal(detail) {
        await this.creerFormulaire(detail);
        this.elBox.classList.remove('non-exist');
        this.elCover.classList.remove('non-exist');
        this.elBody.classList.add('no-scroll');
        const event = new Event('ouvrirMise');
        document.dispatchEvent(event);
    }

    fermerMiser() {
        this.elBox.classList.add('non-exist');
        this.elCover.classList.add('non-exist');
        this.elBody.classList.remove('no-scroll');
    }
}