import React from "react";
import TextField from "@material-ui/core/TextField";

export default function InputField(props) {
    return (
        <TextField
            defaultValue={ props.widget.value }
            disabled={ props.widget.disabled }
            error={ props.widget.error }
            fullWidth={ true }
            helperText={ props.widget.helperText }
            id={ props.widget.id }
            inputProps={ Object.keys(props.widget.attr).length === 0 ? {} : props.widget.attr }
            label={ props.widget.label }
            margin="normal"
            multiline={ props.widget.multiline }
            name={ props.widget.name }
            required={ props.widget.required }
            type={ props.widget.type }
            variant="outlined"
        />
    );
}
