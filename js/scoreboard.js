
const scoreTabs = document.querySelectorAll(".score-tabs__tabs")
const runBtn = document.querySelectorAll(".run-button")
const runOptions = document.querySelector(".run-buttons__grid")
const LBOptions = document.querySelectorAll(".lb-buttons")
const closeLBOptions = document.querySelectorAll(".js-closeLbOptions")
const internalOptions = document.querySelectorAll(".lb-buttons__btn")
const plusMinus = document.querySelectorAll(".-plus-minus")
const togglePlusMinus = document.querySelectorAll(".toggle-plus-minus")
const moreRuns = document.querySelector(".js-more-runs")
const moreRunsDropDown = document.querySelector(".more-runs__drop-down")
const runs = document.querySelectorAll(".runs")
const over = document.querySelector(".over-runs")
let runSide = document.querySelector(".run-side")

// Batsman side

let batsman1 = document.getElementById("batsman-1")
let batsman2 = document.getElementById("batsman-2")

batsman1.textContent = "-"
batsman2.textContent = "-"

let batsman1Runs = document.getElementById("batsman-1-runs")
let batsman2Runs = document.getElementById("batsman-2-runs")

batsman1Runs.textContent = "0"
batsman2Runs.textContent = "0"

let batsman1Balls = document.getElementById("batsman-1-balls")
let batsman2Balls = document.getElementById("batsman-2-balls")

batsman1Balls.textContent = 0
batsman2Balls.textContent = 0

let batsman1Fours = document.getElementById("batsman-1-fours")
let batsman2Fours = document.getElementById("batsman-2-fours")

batsman1Fours.textContent = "0"
batsman2Fours.textContent = "0"

let batsman1Six = document.getElementById("batsman-1-six")
let batsman2Six = document.getElementById("batsman-2-six")

batsman1Six.textContent = "0"
batsman2Six.textContent = "0"

let batsman1SR = document.getElementById("batsman-1-sr")
let batsman2SR = document.getElementById("batsman-2-sr")

batsman1SR.textContent = "0"
batsman2SR.textContent = "0"

// Bowler side

let bowler1 = document.getElementById("bowler-name")

bowler1.textContent = "-"

let bowlerRuns = document.getElementById("bowler-runs")
bowlerRuns.textContent = "0"

let bowlerBalls = document.getElementById("bowler-balls")
bowlerBalls.textContent = "0"

let bowlerFours = document.getElementById("bowler-fours")
bowlerFours.textContent = "0"

let bowlerSix = document.getElementById("bowler-six")
bowlerSix.textContent = "0"

let bowlerSR = document.getElementById("bowler-sr")
bowlerSR.textContent = "0"


let extras = document.getElementById("extra")
extras.textContent = "0"

let partnershipRuns = document.getElementById("partnership-runs")
partnershipRuns.textContent = "0"

let partnershipBalls = document.getElementById("partnership-balls")
partnershipBalls.textContent = "0"

let matchRunRate = document.getElementById("match-run-rate")
matchRunRate.textContent = "0"

let overBalls = document.getElementById("over-balls")
overBalls.textContent = "0"

let totalOvers = document.getElementById("total-overs")
totalOvers.textContent = "0"

let overEnd = 0;

let runsOfTheOver = []


let openedTab;

scoreTabs.forEach((tabs) => {
    tabs.addEventListener("click", () => {
        scoreTabs.forEach((tabs) => tabs.setAttribute("aria-label", "false"))
        tabs.setAttribute("aria-label", "true")
    })
})


runBtn.forEach((btn) => {

    btn.addEventListener("click", () => {
        openedTab = btn
        LBOptions.forEach((opt) => {

            if (openedTab.textContent.trim() === opt.dataset.option) {
                opt.style.display = "flex"
                runOptions.style.display = "none"
            }
            else {
                opt.style.display = "none"
            }
        })
    })
})

runs.forEach((run) => {
    run.addEventListener("click", () => {
        runsOfTheOver.push(run.textContent.trim());

        if (overEnd !== 6) {
            overEnd += run.textContent.trim().includes("NB") || run.textContent.trim().includes("WB") ? 0 : 1
            over.innerHTML = runsOfTheOver.map((roy) => {
                return `<div class="over-runs__circle-wrap --${roy}">
                       ${roy}
                    </div>`;
            }).join('');

            over.scrollLeft = over.scrollWidth;
            let initialValue = 0;
            let matchScore = runsOfTheOver.reduce((accumulator, currentValue) => {
                if (currentValue.includes("WB")) {
                    let wideRuns = parseInt(currentValue) || 0;
                    return accumulator + wideRuns + 1; 
                } else if (currentValue.includes("NB")) {
                    let noBallRuns = parseInt(currentValue) || 0;
                    return accumulator + noBallRuns + 1; 
                } else {
                    return accumulator + parseInt(currentValue); 
                }
            }, initialValue);

            runSide.textContent = matchScore

        }
        else {
            runsOfTheOver = []
            over.innerHTML = ''
            overEnd = 0;
        }
    });
});


plusMinus.forEach((icon) => {
    icon.addEventListener("click", (e) => {
        e.stopPropagation();
        plusMinus.forEach((i) => i.ariaSelected = false)
        icon.setAttribute("aria-selected", "true")

        togglePlusMinus.forEach((tpm) => {
            tpm.textContent = icon.textContent
        })
    })
})

internalOptions.forEach((btn) => {

    btn.addEventListener("click", () => {


        openedTab = btn
        LBOptions.forEach((opt) => {

            if (openedTab.textContent.trim() === opt.dataset.option) {
                opt.style.display = "flex"
                runOptions.style.display = "none"
            }
            else {
                opt.style.display = "none"
            }
        })


    })
})

closeLBOptions.forEach((cls) => {

    cls.addEventListener("click", () => {

        LBOptions.forEach((opt) => {
            if (openedTab.textContent.trim() === opt.dataset.option) {
                opt.style.display = "none"
            }
        })
        runOptions.style.display = "grid"


    })

})

moreRuns.addEventListener("click", (event) => {
    event.stopPropagation();
    moreRunsDropDown.setAttribute("aria-hidden", "false");

})

document.addEventListener("click", () => {
    if (moreRunsDropDown.getAttribute("aria-hidden") === "false") {
        moreRunsDropDown.setAttribute("aria-hidden", "true");
    }
})