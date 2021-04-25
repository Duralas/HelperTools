import React from "react";
import FormControl from "@material-ui/core/FormControl";
import FormHelperText from "@material-ui/core/FormHelperText";
import InputLabel from "@material-ui/core/InputLabel";
import Select from "@material-ui/core/Select";

export default function SelectField(props) {
    const [selectValue, setSelectValue] = React.useState(props.widget.value);

    const handleChange = (event) => {
        setSelectValue(event.target.value);
    };

    const handleChangeMultiple = (event) => {
        const { options } = event.target;
        const value = [];
        for (let i = 0, l = options.length; i < l; i += 1) {
            if (options[i].selected) {
                value.push(options[i].value);
            }
        }
        setSelectValue(value);
    };

    return (
        <FormControl
            disabled={ props.widget.disabled }
            error={ props.widget.error }
            fullWidth={ true }
            margin="normal"
            required={ props.widget.required }
            variant="outlined"
        >
            <InputLabel
                htmlFor={ props.widget.id }
                shrink
            >
                { props.widget.label }
            </InputLabel>
            <Select
                inputProps={ {
                    id: props.widget.id,
                    name: props.widget.name,
                } }
                multiple={ props.widget.multiple }
                native
                onChange={ props.widget.multiple ? handleChangeMultiple : handleChange }
                value={ selectValue }
            >
                {
                    Object.keys(props.widget.choices).map((value) => (
                        <option key={value} value={value}>
                            {props.widget.choices[value]}
                        </option>
                    ))
                }
            </Select>
            <FormHelperText>{ props.widget.helperText }</FormHelperText>
        </FormControl>
    );
}
