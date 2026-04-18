import {defineRule, configure} from "vee-validate";
import * as AllRules from "@vee-validate/rules"

for (let [ruleName, ruleFn] of Object.entries(AllRules)) {
    if (typeof ruleFn === 'function') {
        defineRule(ruleName, ruleFn)
    }
}