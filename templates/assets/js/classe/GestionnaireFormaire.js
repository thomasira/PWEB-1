export default class GestionnaireFormulaire{

    constructor() {
        this.el = document.querySelector('main');
        this.elForm;

        this.init();
    }
    async init() {
        await this.getForm();
        this.initForm();
        this.gererEvenenements();
        
    }

    async getForm() {
        const reponse = await fetch("/templates/enchere/formulaire.html")
        const HTML = await reponse.text();
        this.el.innerHTML = HTML;
        this.elForm = this.el.querySelector('form');
    }

    initForm() {
        const btnAjout = this.elForm.querySelector('[data-js-ajout="timbre"]');

        btnAjout.addEventListener('click', (e) => {
            e.preventDefault();
            const event = new Event('ajoutTimbre');
            document.dispatchEvent(event);
        });
    }


    gererEvenenements() {
        document.addEventListener('ajoutTimbre', () => this.ajouterTimbre());
    }

    async ajouterTimbre() {
        const elTimbres = this.elForm.querySelector('div');

        const reponse = await fetch("/templates/timbre/formulaire.html");
        const HTML = await reponse.text();

        elTimbres.insertAdjacentHTML('beforeend', HTML);
    }
}