import React from "react";

const PricingTable = ({ data }) => {
	return (
		<div className="bg-white rounded-md">
			<div className="flex items-center justify-center gap-2 py-5">
				<span className="text-gray-700 line-through text-xl font-medium">
					{data.price}
				</span>
				<span className="text-gray-700 text-3xl font-bold">
					{data.salePrice}
				</span>
			</div>
			<div className="bg-blue-700 py-4 text-center text-white text-xl font-bold">
				{data.title}
			</div>
			{data.features.map((item, i) => (
				<div className="py-4 text-center font-medium ">
					{item}
				</div>
			))}
			<div className="flex  items-center justify-center p-4">
				<a
					href={data.link}
					target="_blank"
					className="px-8 py-3 no-underline bg-blue-700 text-white cursor-pointer rounded-md"
				>
					Buy Now <i className="fas fa-cart-plus"></i>
				</a>
			</div>
		</div>
	);
};

export default PricingTable;
