import * as d3 from 'd3';

/**
 * Singleton tooltip helper for D3 charts.
 */
function getTooltip() {
    let tooltip = d3.select('#d3-global-tooltip');
    if (tooltip.empty()) {
        tooltip = d3.select('body')
            .append('div')
            .attr('id', 'd3-global-tooltip')
            .attr('class', 'fixed z-50 pointer-events-none opacity-0 transition-opacity duration-150 bg-slate-900/95 text-white text-xs py-2 px-3 rounded-xl shadow-xl border border-slate-700/80 backdrop-blur-md')
            .style('display', 'none');
    }
    return tooltip;
}

function showTooltip(event, title, count, percentage) {
    const tooltip = getTooltip();
    tooltip.html(`
        <div class="font-bold text-slate-100 flex items-center justify-between gap-3">
            <span>${title}</span>
            <span class="text-teal-400 font-mono">${percentage}%</span>
        </div>
        <div class="text-[11px] text-slate-300 mt-0.5">
            Count: <strong class="text-white">${count}</strong> ${count === 1 ? 'employee' : 'employees'}
        </div>
    `);

    const viewportWidth = window.innerWidth || document.documentElement.clientWidth;
    const tooltipX = (event.clientX + 180 > viewportWidth) ? Math.max(10, event.clientX - 180) : (event.clientX + 14);
    const tooltipY = Math.max(10, event.clientY - 42);

    tooltip
        .style('display', 'block')
        .style('left', tooltipX + 'px')
        .style('top', tooltipY + 'px')
        .transition()
        .duration(100)
        .style('opacity', 1);
}

function hideTooltip() {
    const tooltip = getTooltip();
    tooltip
        .transition()
        .duration(150)
        .style('opacity', 0)
        .on('end', function() {
            d3.select(this).style('display', 'none');
        });
}

/**
 * 1. Gender Distribution: Doughnut Chart
 */
export function renderGenderDoughnut(containerId, data) {
    const container = document.getElementById(containerId);
    if (!container) return;
    container.innerHTML = '';

    const total = data.reduce((acc, d) => acc + d.count, 0);
    const width = 320;
    const height = 240;
    const radius = Math.min(width, height) / 2 - 16;
    const innerRadius = radius * 0.62;

    const svg = d3.select(container)
        .append('svg')
        .attr('viewBox', `0 0 ${width} ${height}`)
        .attr('preserveAspectRatio', 'xMidYMid meet')
        .attr('class', 'w-full h-auto max-h-60 mx-auto overflow-visible')
        .append('g')
        .attr('transform', `translate(${width / 2}, ${height / 2})`);

    if (total === 0) {
        svg.append('text')
            .attr('text-anchor', 'middle')
            .attr('class', 'text-xs fill-slate-400 font-medium')
            .text('No gender data recorded');
        return;
    }

    const pie = d3.pie()
        .value(d => d.count)
        .sort(null)
        .padAngle(0.04);

    const arc = d3.arc()
        .innerRadius(innerRadius)
        .outerRadius(radius)
        .cornerRadius(6);

    const arcHover = d3.arc()
        .innerRadius(innerRadius)
        .outerRadius(radius + 6)
        .cornerRadius(6);

    const arcs = svg.selectAll('.arc')
        .data(pie(data))
        .enter()
        .append('g')
        .attr('class', 'arc cursor-pointer');

    arcs.append('path')
        .attr('d', arc)
        .attr('fill', d => d.data.color)
        .attr('stroke', '#ffffff')
        .attr('stroke-width', 2)
        .on('mouseenter', function(event, d) {
            d3.select(this)
                .transition()
                .duration(150)
                .attr('d', arcHover)
                .attr('filter', 'drop-shadow(0px 4px 8px rgba(0,0,0,0.15))');
            showTooltip(event, d.data.label, d.data.count, d.data.percentage);
        })
        .on('mousemove', function(event, d) {
            showTooltip(event, d.data.label, d.data.count, d.data.percentage);
        })
        .on('mouseleave', function() {
            d3.select(this)
                .transition()
                .duration(150)
                .attr('d', arc)
                .attr('filter', null);
            hideTooltip();
        });

    // Center Summary Metric
    svg.append('text')
        .attr('text-anchor', 'middle')
        .attr('dy', '-0.15em')
        .attr('class', 'text-2xl font-extrabold fill-slate-900 tracking-tight')
        .text(total);

    svg.append('text')
        .attr('text-anchor', 'middle')
        .attr('dy', '1.3em')
        .attr('class', 'text-[11px] font-semibold uppercase tracking-wider fill-slate-400')
        .text('Staff Total');
}

/**
 * 2. Education Distribution: Bar Chart
 */
export function renderEducationBarChart(containerId, data) {
    const container = document.getElementById(containerId);
    if (!container) return;
    container.innerHTML = '';

    const width = 460;
    const height = 240;
    const margin = { top: 20, right: 20, bottom: 42, left: 36 };

    const svg = d3.select(container)
        .append('svg')
        .attr('viewBox', `0 0 ${width} ${height}`)
        .attr('preserveAspectRatio', 'xMidYMid meet')
        .attr('class', 'w-full h-auto max-h-60');

    const x = d3.scaleBand()
        .domain(data.map(d => d.label))
        .range([margin.left, width - margin.right])
        .padding(0.35);

    const maxVal = d3.max(data, d => d.count) || 5;
    const y = d3.scaleLinear()
        .domain([0, Math.max(maxVal + 1, 4)])
        .nice()
        .range([height - margin.bottom, margin.top]);

    // Background horizontal grid lines
    svg.append('g')
        .attr('class', 'grid text-slate-200')
        .attr('transform', `translate(${margin.left},0)`)
        .call(d3.axisLeft(y)
            .ticks(4)
            .tickSize(-(width - margin.left - margin.right))
            .tickFormat('')
        )
        .call(g => g.select('.domain').remove())
        .call(g => g.selectAll('.tick line').attr('stroke-dasharray', '3,3'));

    // X Axis
    svg.append('g')
        .attr('transform', `translate(0,${height - margin.bottom})`)
        .call(d3.axisBottom(x).tickSize(0))
        .call(g => g.select('.domain').attr('stroke', '#CBD5E1'))
        .call(g => g.selectAll('.tick text')
            .attr('class', 'text-xs font-semibold fill-slate-600')
            .attr('dy', '1.2em')
        );

    // Y Axis
    svg.append('g')
        .attr('transform', `translate(${margin.left},0)`)
        .call(d3.axisLeft(y).ticks(4).tickFormat(d3.format('d')))
        .call(g => g.select('.domain').remove())
        .call(g => g.selectAll('.tick text')
            .attr('class', 'text-[11px] font-mono fill-slate-400')
        );

    // Bars
    svg.selectAll('.bar')
        .data(data)
        .enter()
        .append('rect')
        .attr('class', 'bar cursor-pointer transition-all duration-200')
        .attr('x', d => x(d.label))
        .attr('y', d => y(d.count))
        .attr('height', d => Math.max(0, y(0) - y(d.count)))
        .attr('width', x.bandwidth())
        .attr('rx', 5)
        .attr('fill', d => d.color)
        .on('mouseenter', function(event, d) {
            d3.select(this)
                .attr('opacity', 0.82)
                .attr('filter', 'drop-shadow(0px 3px 6px rgba(0,0,0,0.12))');
            showTooltip(event, `Education: ${d.label}`, d.count, d.percentage);
        })
        .on('mousemove', function(event, d) {
            showTooltip(event, `Education: ${d.label}`, d.count, d.percentage);
        })
        .on('mouseleave', function() {
            d3.select(this)
                .attr('opacity', 1)
                .attr('filter', null);
            hideTooltip();
        });

    // Top Value Labels on Bars
    svg.selectAll('.bar-label')
        .data(data)
        .enter()
        .append('text')
        .attr('class', 'text-[11px] font-bold fill-slate-700 pointer-events-none')
        .attr('x', d => x(d.label) + x.bandwidth() / 2)
        .attr('y', d => y(d.count) - 6)
        .attr('text-anchor', 'middle')
        .text(d => d.count > 0 ? d.count : '');
}

/**
 * 3. Age Distribution: Bar Chart
 */
export function renderAgeBarChart(containerId, data) {
    const container = document.getElementById(containerId);
    if (!container) return;
    container.innerHTML = '';

    const width = 460;
    const height = 240;
    const margin = { top: 20, right: 20, bottom: 42, left: 36 };

    const svg = d3.select(container)
        .append('svg')
        .attr('viewBox', `0 0 ${width} ${height}`)
        .attr('preserveAspectRatio', 'xMidYMid meet')
        .attr('class', 'w-full h-auto max-h-60');

    const x = d3.scaleBand()
        .domain(data.map(d => d.label))
        .range([margin.left, width - margin.right])
        .padding(0.35);

    const maxVal = d3.max(data, d => d.count) || 5;
    const y = d3.scaleLinear()
        .domain([0, Math.max(maxVal + 1, 4)])
        .nice()
        .range([height - margin.bottom, margin.top]);

    // Grid
    svg.append('g')
        .attr('class', 'grid text-slate-200')
        .attr('transform', `translate(${margin.left},0)`)
        .call(d3.axisLeft(y)
            .ticks(4)
            .tickSize(-(width - margin.left - margin.right))
            .tickFormat('')
        )
        .call(g => g.select('.domain').remove())
        .call(g => g.selectAll('.tick line').attr('stroke-dasharray', '3,3'));

    // X Axis
    svg.append('g')
        .attr('transform', `translate(0,${height - margin.bottom})`)
        .call(d3.axisBottom(x).tickSize(0))
        .call(g => g.select('.domain').attr('stroke', '#CBD5E1'))
        .call(g => g.selectAll('.tick text')
            .attr('class', 'text-xs font-semibold fill-slate-600')
            .attr('dy', '1.2em')
        );

    // Y Axis
    svg.append('g')
        .attr('transform', `translate(${margin.left},0)`)
        .call(d3.axisLeft(y).ticks(4).tickFormat(d3.format('d')))
        .call(g => g.select('.domain').remove())
        .call(g => g.selectAll('.tick text')
            .attr('class', 'text-[11px] font-mono fill-slate-400')
        );

    // Bars
    svg.selectAll('.bar')
        .data(data)
        .enter()
        .append('rect')
        .attr('class', 'bar cursor-pointer transition-all duration-200')
        .attr('x', d => x(d.label))
        .attr('y', d => y(d.count))
        .attr('height', d => Math.max(0, y(0) - y(d.count)))
        .attr('width', x.bandwidth())
        .attr('rx', 5)
        .attr('fill', d => d.color)
        .on('mouseenter', function(event, d) {
            d3.select(this)
                .attr('opacity', 0.82)
                .attr('filter', 'drop-shadow(0px 3px 6px rgba(0,0,0,0.12))');
            showTooltip(event, `Age: ${d.label} yrs`, d.count, d.percentage);
        })
        .on('mousemove', function(event, d) {
            showTooltip(event, `Age: ${d.label} yrs`, d.count, d.percentage);
        })
        .on('mouseleave', function() {
            d3.select(this)
                .attr('opacity', 1)
                .attr('filter', null);
            hideTooltip();
        });

    // Value Labels
    svg.selectAll('.bar-label')
        .data(data)
        .enter()
        .append('text')
        .attr('class', 'text-[11px] font-bold fill-slate-700 pointer-events-none')
        .attr('x', d => x(d.label) + x.bandwidth() / 2)
        .attr('y', d => y(d.count) - 6)
        .attr('text-anchor', 'middle')
        .text(d => d.count > 0 ? d.count : '');
}

/**
 * 4. Work Duration Distribution: Bar Chart
 */
export function renderWorkDurationBarChart(containerId, data) {
    const container = document.getElementById(containerId);
    if (!container) return;
    container.innerHTML = '';

    const width = 460;
    const height = 240;
    const margin = { top: 20, right: 20, bottom: 42, left: 36 };

    const svg = d3.select(container)
        .append('svg')
        .attr('viewBox', `0 0 ${width} ${height}`)
        .attr('preserveAspectRatio', 'xMidYMid meet')
        .attr('class', 'w-full h-auto max-h-60');

    const x = d3.scaleBand()
        .domain(data.map(d => d.label))
        .range([margin.left, width - margin.right])
        .padding(0.35);

    const maxVal = d3.max(data, d => d.count) || 5;
    const y = d3.scaleLinear()
        .domain([0, Math.max(maxVal + 1, 4)])
        .nice()
        .range([height - margin.bottom, margin.top]);

    // Grid
    svg.append('g')
        .attr('class', 'grid text-slate-200')
        .attr('transform', `translate(${margin.left},0)`)
        .call(d3.axisLeft(y)
            .ticks(4)
            .tickSize(-(width - margin.left - margin.right))
            .tickFormat('')
        )
        .call(g => g.select('.domain').remove())
        .call(g => g.selectAll('.tick line').attr('stroke-dasharray', '3,3'));

    // X Axis
    svg.append('g')
        .attr('transform', `translate(0,${height - margin.bottom})`)
        .call(d3.axisBottom(x).tickSize(0))
        .call(g => g.select('.domain').attr('stroke', '#CBD5E1'))
        .call(g => g.selectAll('.tick text')
            .attr('class', 'text-xs font-semibold fill-slate-600')
            .attr('dy', '1.2em')
        );

    // Y Axis
    svg.append('g')
        .attr('transform', `translate(${margin.left},0)`)
        .call(d3.axisLeft(y).ticks(4).tickFormat(d3.format('d')))
        .call(g => g.select('.domain').remove())
        .call(g => g.selectAll('.tick text')
            .attr('class', 'text-[11px] font-mono fill-slate-400')
        );

    // Bars
    svg.selectAll('.bar')
        .data(data)
        .enter()
        .append('rect')
        .attr('class', 'bar cursor-pointer transition-all duration-200')
        .attr('x', d => x(d.label))
        .attr('y', d => y(d.count))
        .attr('height', d => Math.max(0, y(0) - y(d.count)))
        .attr('width', x.bandwidth())
        .attr('rx', 5)
        .attr('fill', d => d.color)
        .on('mouseenter', function(event, d) {
            d3.select(this)
                .attr('opacity', 0.82)
                .attr('filter', 'drop-shadow(0px 3px 6px rgba(0,0,0,0.12))');
            showTooltip(event, `Experience: ${d.label}`, d.count, d.percentage);
        })
        .on('mousemove', function(event, d) {
            showTooltip(event, `Experience: ${d.label}`, d.count, d.percentage);
        })
        .on('mouseleave', function() {
            d3.select(this)
                .attr('opacity', 1)
                .attr('filter', null);
            hideTooltip();
        });

    // Value Labels
    svg.selectAll('.bar-label')
        .data(data)
        .enter()
        .append('text')
        .attr('class', 'text-[11px] font-bold fill-slate-700 pointer-events-none')
        .attr('x', d => x(d.label) + x.bandwidth() / 2)
        .attr('y', d => y(d.count) - 6)
        .attr('text-anchor', 'middle')
        .text(d => d.count > 0 ? d.count : '');
}

/**
 * Universal Dashboard Charts Initializer.
 */
export function initAllDashboardCharts(chartData) {
    if (!chartData) return;

    if (chartData.gender) {
        renderGenderDoughnut('chart-gender-distribution', chartData.gender);
    }
    if (chartData.education) {
        renderEducationBarChart('chart-education-distribution', chartData.education);
    }
    if (chartData.age) {
        renderAgeBarChart('chart-age-distribution', chartData.age);
    }
    if (chartData.workDuration) {
        renderWorkDurationBarChart('chart-work-duration-distribution', chartData.workDuration);
    }
}

