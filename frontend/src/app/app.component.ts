import {Component, ViewChild} from '@angular/core';
import {MatTableDataSource} from "@angular/material/table";
import {MatPaginator} from "@angular/material/paginator";
import {MatDialog} from "@angular/material/dialog";
import {DialogDataExampleDialog} from "./dialog.component";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  ordersTotal = 0;
  displayedColumns = ['id', 'date', 'customer', 'address1', 'city', 'postcode', 'country', 'amount', 'status', 'deleted', 'lastModified', 'actions'];
  dataSource: MatTableDataSource<OrderData>;
  orders: OrderData[] = [];
  @ViewChild(MatPaginator, { static: false }) paginator: MatPaginator;

  ngAfterViewInit() {
    this.fetchFirstPageData();
  }

  constructor(public dialog: MatDialog) {}

  async fetchFirstPageData() {
    try {
      const raw = await fetch("/orders");
      const result = await raw.json();
      this.orders = result.data;
      this.ordersTotal = result.count;
      this.dataSource = new MatTableDataSource(this.orders);
      this.dataSource.paginator = this.paginator;
    } catch (e) {
      console.error("Failed to fetch orders, please try again later");
      this.dialog.open(DialogDataExampleDialog, {
        data: "Something went wrong"
      });
    }
  }

  async onCancelOrder(id: number) {
    try {
      const raw = await fetch(`/orders/${id}/cancel`, { method: 'PUT' });
      const result = await raw.json();

      for (let order of this.orders) {
        if(order.id === id) {
          order.status = "cancelled";
          this.dataSource.data = this.orders;
          break;
        }
      }

      // TODO: change state of canceled order if success
      this.dialog.open(DialogDataExampleDialog, {
        data: `Order ${id} successfully canceled!`
      });
    } catch (e) {
      console.error("Failed to cancel order, please try again later");
      this.dialog.open(DialogDataExampleDialog, {
        data: "Something went wrong"
      });
    }

  }

  onPaginate(e: any) {
    fetch(`/orders?page=${e.pageIndex}`).then((res) => res.json()).then((result: any) => {
      this.orders = result.data;
      this.ordersTotal = result.count;
      this.dataSource.data = this.orders;
    });
  }

  applyFilter(filterValue: string) {
    filterValue = filterValue.trim(); // Remove whitespace
    filterValue = filterValue.toLowerCase(); // Datasource defaults to lowercase matches
    this.dataSource.filter = filterValue;
  }
}


export interface OrderData {
  "id": number,
  "date": string,
  "customer": string,
  "address1": string,
  "city": string,
  "postcode": string,
  "country": string,
  "amount": number,
  "status": string,
  "deleted": string,
  "lastModified": string
}
