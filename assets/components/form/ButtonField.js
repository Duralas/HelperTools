import React from "react";
import Button from "@material-ui/core/Button";

export default function ButtonField(props) {
    return (
        <Button
            color={ "primary" }
            disabled={ props.widget.disabled }
            fullWidth={ true }
            id={ props.widget.id }
            name={ props.widget.name }
            type={ props.widget.type }
            variant="contained"
        >
            { props.widget.label }
        </Button>
    );
}
