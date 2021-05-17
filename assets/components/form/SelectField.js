import React from "react";
// import Checkbox from '@material-ui/core/Checkbox';
import FormControl from "@material-ui/core/FormControl";
import FormHelperText from "@material-ui/core/FormHelperText";
import InputLabel from "@material-ui/core/InputLabel";
// import ListItemText from '@material-ui/core/ListItemText';
// import MenuItem from '@material-ui/core/MenuItem';
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

    // const displaySelected = (selected) => selected.map((value) => props.widget.choices[value]).join(", ");

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
                // native={ props.widget.multiple === false }
                // renderValue={ displaySelected }
                // onChange={ handleChange }
                // value={ selectValue }
            >
                {
                    // Object.keys(props.widget.choices).map((value) => (
                    //     props.widget.multiple
                    //         ? <MenuItem key={value} value={value}>
                    //             <Checkbox checked={selectValue.indexOf(value) > -1} />
                    //             <ListItemText primary={props.widget.choices[value]} />
                    //         </MenuItem>
                    //         : <option key={value} value={value}>
                    //             {props.widget.choices[value]}
                    //         </option>
                    // ))
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
