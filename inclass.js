const btn_add_step= document.querySelector(add_step)
const steps_fieldset= document.querySelector(steps_fieldset)

let step_count = 0 
    function add_step_input() {
        const div=document.createElement(`div`)

        const label= document.createElement
        label.setAttribute('for' , `step-${step_count}`)
        label.textContent = `Step ${step_count +1 }`
        
        
        const input =document.createElement (`input`)
        input.type='text'
        input.required= true
        input.id = `step-${step_count}`
        input.name= 'step[]'


    }
//Dont do step 1 step two step 3; instead to STEPS: Method called: Implode

//for each item in the array its going to take one and two and put them together 
//$steps = implode ('*' , $step_list');

// add_steps $con, (int) $id, steps;
