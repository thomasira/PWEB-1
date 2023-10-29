

export class Calculatrice{

    /**
     * trouve l'angle entre 2 points selon leurs coordonnées x et y
     * 
     * @param {*} xy1 -> objet 1 contenant une proprietée x et y
     * @param {*} xy2 -> objet 2 bis
     * @returns -> INT un angle compris entre 0 et 360 (peut retourner des valeurs négatives équivalentes) 
     */
    static getAngle(xy1, xy2) {
        return Math.atan2(xy1.y - xy2.y, xy1.x - xy2.x ) * ( 180 / Math.PI );
    }
}