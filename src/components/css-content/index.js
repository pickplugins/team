const { Component } = wp.element;
import { __ } from "@wordpress/i18n";
import { Button, Dropdown } from "@wordpress/components";
import { useState } from "@wordpress/element";
import {
	__experimentalInputControl as InputControl,
	ColorPalette,
} from "@wordpress/components";
function Html(props) {
	if (!props.warn) {
		return null;
	}
	var content = props.val == null || props.val == undefined ? " " : props.val;
	content = props.val.replaceAll('"', "");
	content = content.replaceAll("u2018", "'");
	content = content.replaceAll("u0022", "");

	return (
		<div className="mt-4">
			<InputControl
				value={content}
				type="text"
				onChange={(newVal) => {
					if (newVal.includes("attr")) {

						newVal = newVal.replaceAll('"', "u0022");
						newVal = newVal.replaceAll('"', "u2018");

						props.onChange(newVal, "content");
					}
					//setwidthVal(newVal);
					else {
						newVal = newVal.replaceAll('"', "u0022");
						newVal = newVal.replaceAll("'", "u2018");
						newVal = 'u0022' + newVal + 'u0022';

						console.log(newVal);

						props.onChange(newVal, "content");
					}
				}}
			/>
		</div>
	);
}
class PGcssContent extends Component {
	constructor(props) {
		super(props);
		this.state = { showWarning: true };
		this.handleToggleClick = this.handleToggleClick.bind(this);
	}
	handleToggleClick() {
		this.setState((state) => ({
			showWarning: !state.showWarning,
		}));
	}
	render() {
		var { val, onChange } = this.props;
		return <Html val={val} onChange={onChange} warn={this.state.showWarning} />;
	}
}
export default PGcssContent;
