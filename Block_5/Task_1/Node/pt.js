const DANGER_1 = '1111111';
const DANGER_0 = '0000000';
                   //123456789
let randSituation = '110011001101';

let message = (
    (randSituation.indexOf(DANGER_1) != -1) || randSituation.indexOf(DANGER_0) != -1 ) ? "YES" : "NO";

console.log(message);