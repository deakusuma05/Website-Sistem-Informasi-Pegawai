import './bootstrap';
import Alpine from 'alpinejs';
import * as d3 from 'd3';
import * as DashboardCharts from './dashboard-charts';

window.Alpine = Alpine;
window.d3 = d3;
window.DashboardCharts = DashboardCharts;

Alpine.start();
