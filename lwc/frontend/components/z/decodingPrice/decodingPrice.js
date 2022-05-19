import { LightningElement, track, api } from "lwc";
import "./decodingPrice.scss";

export default class DecodingPrice extends LightningElement {
  @api settings;

  get needBreakets() {
    return (
      this.season.price_block.min_percent ||
      this.season.price_block.people_sale ||
      this.season.price_block.days_sale
    );
  }

  get price() {
    return this.season.price_block.min_percent
      ? this.season.price_block.base_price_without_upper
      : this.season.price_block.base_price;
  }

  get seasons() {
    return Object.values(this.settings.total.seasons_group);
  }

//   food:
//     breakfast: {total_price: 0, price: 15, count: 0}
//     dinner: {total_price: 30, price: 10, count: 3}
//     lunch: {total_price: 40, price: 20, count: 2}


}
