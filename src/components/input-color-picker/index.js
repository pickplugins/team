const { Component } = wp.element;
import {
	Button,
	Dropdown,
	ColorPalette,
	PanelRow,
	__experimentalInputControl as InputControl,
	Popover,
} from "@wordpress/components";

import {
	memo,
	useMemo,
	useState,
	useRef,
	useEffect,
	useCallback,
} from "@wordpress/element";
import breakPoints from "../../breakpoints";

function WarningBanner(props) {
	if (!props.warn) {
		return null;
	}

	return (
		<div>
			<Popover position="bottom right">
				<div className="p-2">
					<ColorPalette
						value={props.value}
						colors={props.colors}
						enableAlpha
						onChange={(newVal) => {
							props.onChange(newVal);
						}}
					/>
				</div>
			</Popover>
		</div>
	);
}

class PGColorPicker extends Component {
	constructor(props) {
		super(props);
		this.state = { showWarning: false };
		this.handleToggleClick = this.handleToggleClick.bind(this);
	}

	handleToggleClick() {
		this.setState((state) => ({
			showWarning: !state.showWarning,
		}));
	}

	render() {
		var { value, colors, enableAlpha, onChange, label, initialOpen } =
			this.props;

		var placeholderStyle = {
			backgroundImage:
				"repeating-linear-gradient(45deg,#e0e0e0 25%,transparent 0,transparent 75%,#e0e0e0 0,#e0e0e0),repeating-linear-gradient(45deg,#e0e0e0 25%,transparent 0,transparent 75%,#e0e0e0 0,#e0e0e0)",
			backgroundPosition: "0 0,25px 25px",
			backgroundSize: "50px 50px",
			boxShadow: "inset 0 0 0 1px rgb(0 0 0 / 20%)",

			cursor: "pointer",
		};

		var defaultbtnStyle = {
			backgroundImage:
				"repeating-linear-gradient(45deg,#e0e0e0 25%,transparent 0,transparent 75%,#e0e0e0 0,#e0e0e0),repeating-linear-gradient(45deg,#e0e0e0 25%,transparent 0,transparent 75%,#e0e0e0 0,#e0e0e0)",
			backgroundPosition: "0 0,25px 25px",
			backgroundSize: "50px 50px",
			boxShadow: "inset 0 0 0 1px rgb(0 0 0 / 20%)",

			cursor: "pointer",
		};

		var btnStyle = {
			backgroundColor: value,
			boxShadow: "inset 0 0 0 1px rgb(0 0 0 / 20%)",

			cursor: "pointer",
		};

		return (
			<div>
				<div className="my-4">
					<div className="flex justify-between items-center mb-3">{label}</div>

					<div className="relative h-10" style={placeholderStyle}>
						<div
							className="absolute w-full  h-full top-0 left-0 text-center"
							style={btnStyle}
							onClick={this.handleToggleClick}>
							<span className="w-full text-center left-0 top-1/2 -translate-y-1/2	 absolute">
								{value == undefined ? "Set Color" : value}
							</span>
						</div>
					</div>
				</div>
				<WarningBanner
					colors={colors}
					enableAlpha={enableAlpha}
					initialOpen={initialOpen}
					value={value}
					onChange={onChange}
					warn={this.state.showWarning}
				/>
			</div>
		);
	}
}

export default PGColorPicker;

