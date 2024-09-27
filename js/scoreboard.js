
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
let overEnd = 0;

let runsOfTheOver = []




let openedTab;

scoreTabs.forEach((tabs) => {
    tabs.addEventListener("click", () => {
        scoreTabs.forEach((tabs) => tabs.setAttribute("aria-label","false"))
        tabs.setAttribute("aria-label","true")
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

        if(overEnd !== 6)
        {

            overEnd += run.textContent.trim().includes("NB") || run.textContent.trim().includes("WB") ? 0 : 1
            
           over.innerHTML = runsOfTheOver.map((roy) => {
            return `<div class="over-runs__circle-wrap --${roy}">
                       ${roy}
                    </div>`;
            }).join('');        
     
        }
        else{
            runsOfTheOver = []
            over.innerHTML = ''
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

    moreRuns.addEventListener("click" , (event) => {
        event.stopPropagation();
        moreRunsDropDown.setAttribute("aria-hidden", "false");
        
    })

    document.addEventListener("click", () => {
        if (moreRunsDropDown.getAttribute("aria-hidden") === "false") {
            moreRunsDropDown.setAttribute("aria-hidden", "true");
        }
    })