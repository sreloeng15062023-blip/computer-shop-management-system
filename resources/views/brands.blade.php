<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Brand Management – Computer Shop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@600;700&family=Figtree:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f2f5f4;
            --surface: #fff;
            --ink: #16211f;
            --muted: #5d6b68;
            --line: #d6dedc;
            --accent: #0e7c66;
            --accent-ink: #fff;
            --soft: #e2f1ed;
            --danger: #b42318;
            --warn: #b45309;
            box-sizing: border-box;
            padding-top: env(safe-area-inset-top, 0px);
            padding-bottom: env(safe-area-inset-bottom, 0px)
        }

        @media(prefers-color-scheme:dark) {
            :root:not([data-theme="light"]) {
                --bg: #0f1716;
                --surface: #172321;
                --ink: #e6efed;
                --muted: #93a5a1;
                --line: #2a3b38;
                --accent: #3fc2a3;
                --accent-ink: #06211b;
                --soft: #1d3833;
                --danger: #f97066;
                --warn: #f5a54a
            }
        }

        :root[data-theme="dark"] {
            --bg: #0f1716;
            --surface: #172321;
            --ink: #e6efed;
            --muted: #93a5a1;
            --line: #2a3b38;
            --accent: #3fc2a3;
            --accent-ink: #06211b;
            --soft: #1d3833;
            --danger: #f97066;
            --warn: #f5a54a
        }

        * {
            box-sizing: border-box
        }

        html {
            scroll-padding-top: env(safe-area-inset-top, 0px)
        }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--ink);
            font: 400 15px/1.5 Figtree, system-ui, sans-serif
        }

        h1,
        h2 {
            font-family: "Bricolage Grotesque", Figtree, sans-serif;
            margin: 0;
            letter-spacing: -.01em
        }

        .wrap {
            max-width: 1080px;
            margin: 0 auto;
            padding: 24px 16px 48px
        }

        header {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 20px
        }

        h1 {
            font-size: clamp(28px, 5vw, 40px);
            line-height: 1.1
        }

        header p {
            margin: 4px 0 0;
            color: var(--muted)
        }

        button {
            font: inherit;
            cursor: pointer;
            border-radius: 8px;
            border: 1px solid var(--line);
            background: var(--surface);
            color: var(--ink);
            padding: 8px 14px
        }

        button:hover {
            border-color: var(--accent)
        }

        button:focus-visible,
        input:focus-visible,
        select:focus-visible,
        textarea:focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 2px
        }

        .primary {
            background: var(--accent);
            color: var(--accent-ink);
            border-color: var(--accent);
            font-weight: 600
        }

        .danger {
            color: var(--danger)
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 16px
        }

        .stat {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 14px 16px
        }

        .stat b {
            display: block;
            font: 700 30px/1.1 "Bricolage Grotesque", sans-serif
        }

        .stat span {
            color: var(--muted);
            font-size: 13px
        }

        .panel {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 16px
        }

        .panel h2 {
            font-size: 18px;
            margin-bottom: 12px
        }

        .bars {
            display: grid;
            gap: 10px
        }

        .bar {
            display: grid;
            grid-template-columns: 110px 1fr 56px;
            gap: 10px;
            align-items: center;
            font-size: 14px
        }

        .track {
            height: 14px;
            background: var(--soft);
            border-radius: 4px;
            overflow: hidden
        }

        .fill {
            height: 100%;
            background: var(--accent);
            border-radius: 4px;
            transition: width .5s
        }

        .bar em {
            font-style: normal;
            text-align: right;
            color: var(--muted)
        }

        .tools {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 12px
        }

        input,
        select,
        textarea {
            font: inherit;
            color: var(--ink);
            background: var(--bg);
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 8px 10px;
            width: 100%
        }

        .tools input {
            flex: 1 1 220px;
            width: auto
        }

        .tools select {
            width: auto
        }

        .scroll {
            overflow-x: auto
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 640px
        }

        th,
        td {
            text-align: left;
            padding: 10px 8px;
            border-bottom: 1px solid var(--line);
            vertical-align: middle
        }

        th {
            font-weight: 600;
            color: var(--muted);
            font-size: 13px
        }

        td.n {
            font-variant-numeric: tabular-nums
        }

        .name {
            font-weight: 600
        }

        .desc {
            color: var(--muted);
            font-size: 13px
        }

        .badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 600;
            background: var(--soft);
            color: var(--accent)
        }

        .badge.off {
            background: transparent;
            border: 1px solid var(--line);
            color: var(--muted)
        }

        td.act {
            white-space: nowrap;
            text-align: right
        }

        td.act button {
            padding: 5px 10px;
            font-size: 13px
        }

        .empty {
            padding: 28px;
            text-align: center;
            color: var(--muted)
        }

        dialog {
            border: 1px solid var(--line);
            border-radius: 14px;
            background: var(--surface);
            color: var(--ink);
            padding: 22px;
            width: min(440px, 92vw)
        }

        dialog::backdrop {
            background: rgba(0, 0, 0, .45)
        }

        label {
            display: block;
            font-weight: 600;
            font-size: 13px;
            margin: 12px 0 4px
        }

        .row {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
            margin-top: 18px
        }

        .err {
            color: var(--danger);
            font-size: 13px;
            min-height: 18px;
            margin-top: 6px
        }

        #toast {
            position: fixed;
            left: 50%;
            bottom: calc(20px + env(safe-area-inset-bottom, 0px));
            transform: translateX(-50%);
            background: var(--ink);
            color: var(--bg);
            padding: 10px 16px;
            border-radius: 8px;
            opacity: 0;
            pointer-events: none;
            transition: opacity .2s
        }

        #toast.show {
            opacity: 1
        }

        @media(max-width:700px) {
            .stats {
                grid-template-columns: repeat(2, 1fr)
            }

            .bar {
                grid-template-columns: 80px 1fr 44px
            }
        }

        @media(prefers-reduced-motion:reduce) {
            * {
                transition: none !important
            }
        }
    </style>
</head>

<body>
    <div class="wrap">
        <header>
            <div>
                <h1>Brands</h1>
                <p>Manufacturers and labels the shop stocks, with what each one contributes to inventory.</p>
            </div>
            <button class="primary" id="addBtn">Add brand</button>
        </header>

        <section class="stats" id="stats" aria-label="Brand summary"></section>

        <section class="panel">
            <h2>Stock units by brand</h2>
            <div class="bars" id="bars"></div>
        </section>

        <section class="panel">
            <div class="tools">
                <input id="q" type="search" placeholder="Search by name, country or description" aria-label="Search brands">
                <select id="filter" aria-label="Filter by status">
                    <option value="">All statuses</option>
                    <option>Active</option>
                    <option>Inactive</option>
                </select>
            </div>
            <div class="scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Brand</th>
                            <th>Country</th>
                            <th>Products</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="rows"></tbody>
                </table>
            </div>
            <div class="empty" id="empty" hidden>No brands match your search.</div>
        </section>
    </div>

    <dialog id="form">
        <h2 id="formTitle">Add brand</h2>
        <label for="fName">Brand name</label>
        <input id="fName" maxlength="50" autocomplete="off">
        <label for="fCountry">Country</label>
        <input id="fCountry" maxlength="50" autocomplete="off">
        <label for="fDesc">Description</label>
        <textarea id="fDesc" rows="3"></textarea>
        <label for="fStatus">Status</label>
        <select id="fStatus">
            <option>Active</option>
            <option>Inactive</option>
        </select>
        <div class="err" id="err" role="alert"></div>
        <div class="row"><button id="cancel">Cancel</button><button class="primary" id="save">Save</button></div>
    </dialog>

    <dialog id="confirm">
        <h2>Delete brand</h2>
        <p id="confirmMsg"></p>
        <div class="row"><button id="noDel">Cancel</button><button class="primary danger" id="yesDel" style="background:var(--danger);color:#fff;border-color:var(--danger)">Delete</button></div>
    </dialog>
    <div id="toast" role="status"></div>

    <script>
        // Seed data mirrors the INSERTs in assignment_y2s2_web_app_framework.sql (brands + products)
        let nextId = 5;
        let brands = [{
                BrandID: 1,
                BrandName: 'ASUS',
                Country: 'Taiwan',
                Description: 'Gaming laptops and hardware',
                Status: 'Active',
                CreatedAt: '2026-09-01'
            },
            {
                BrandID: 2,
                BrandName: 'Dell',
                Country: 'USA',
                Description: 'Business computers and monitors',
                Status: 'Active',
                CreatedAt: '2026-09-01'
            },
            {
                BrandID: 3,
                BrandName: 'Logitech',
                Country: 'Switzerland',
                Description: 'Computer peripherals and accessories',
                Status: 'Active',
                CreatedAt: '2026-09-01'
            },
            {
                BrandID: 4,
                BrandName: 'Kingston',
                Country: 'USA',
                Description: 'RAM and storage devices',
                Status: 'Active',
                CreatedAt: '2026-09-01'
            }
        ];
        const products = [{
                BrandID: 1,
                StockQuantity: 10
            }, {
                BrandID: 3,
                StockQuantity: 25
            },
            {
                BrandID: 2,
                StockQuantity: 8
            }, {
                BrandID: 4,
                StockQuantity: 30
            }
        ];
        const $ = id => document.getElementById(id);
        const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;'
        } [c]));
        const usage = id => products.filter(p => p.BrandID === id).reduce((a, p) => ({
            n: a.n + 1,
            stock: a.stock + p.StockQuantity
        }), {
            n: 0,
            stock: 0
        });
        let editingId = null,
            deletingId = null;

        function toast(msg) {
            const t = $('toast');
            t.textContent = msg;
            t.classList.add('show');
            clearTimeout(toast.t);
            toast.t = setTimeout(() => t.classList.remove('show'), 2200)
        }

        function renderStats() {
            const active = brands.filter(b => b.Status === 'Active').length;
            const linked = new Set(products.map(p => p.BrandID)).size;
            const stock = products.reduce((a, p) => a + p.StockQuantity, 0);
            const items = [
                [brands.length, 'Total brands'],
                [active, 'Active'],
                [brands.length - active, 'Inactive'],
                [stock, 'Units in stock']
            ];
            $('stats').innerHTML = items.map(([v, l]) => `<div class="stat"><b>${v}</b><span>${l}</span></div>`).join('');
        }

        function renderBars() {
            const data = brands.map(b => ({
                name: b.BrandName,
                stock: usage(b.BrandID).stock
            })).sort((a, b) => b.stock - a.stock);
            const max = Math.max(1, ...data.map(d => d.stock));
            $('bars').innerHTML = data.length ? data.map(d => `<div class="bar"><span>${esc(d.name)}</span><div class="track"><div class="fill" style="width:${d.stock/max*100}%"></div></div><em>${d.stock}</em></div>`).join('') : '<div class="empty">No brands yet.</div>';
        }

        function renderTable() {
            const q = $('q').value.trim().toLowerCase(),
                f = $('filter').value;
            const list = brands.filter(b => (!f || b.Status === f) && (!q || [b.BrandName, b.Country, b.Description].join(' ').toLowerCase().includes(q)));
            $('rows').innerHTML = list.map(b => {
                const u = usage(b.BrandID);
                return `<tr>
    <td><div class="name">${esc(b.BrandName)}</div><div class="desc">${esc(b.Description)}</div></td>
    <td>${esc(b.Country)||'–'}</td><td class="n">${u.n}</td><td class="n">${u.stock}</td>
    <td><span class="badge ${b.Status==='Active'?'':'off'}">${b.Status}</span></td>
    <td class="n">${b.CreatedAt}</td>
    <td class="act"><button data-edit="${b.BrandID}">Edit</button> <button class="danger" data-del="${b.BrandID}">Delete</button></td></tr>`
            }).join('');
            $('empty').hidden = list.length > 0;
        }

        function render() {
            renderStats();
            renderBars();
            renderTable()
        }

        function openForm(id) {
            editingId = id ?? null;
            const b = brands.find(x => x.BrandID === id) || {
                BrandName: '',
                Country: '',
                Description: '',
                Status: 'Active'
            };
            $('formTitle').textContent = id ? 'Update brand' : 'Add brand';
            $('fName').value = b.BrandName;
            $('fCountry').value = b.Country || '';
            $('fDesc').value = b.Description || '';
            $('fStatus').value = b.Status;
            $('err').textContent = '';
            $('form').showModal();
            $('fName').focus();
        }

        function save() {
            const name = $('fName').value.trim();
            if (!name) {
                $('err').textContent = 'Brand name is required.';
                return
            }
            if (brands.some(b => b.BrandName.toLowerCase() === name.toLowerCase() && b.BrandID !== editingId)) {
                $('err').textContent = 'A brand with this name already exists.';
                return
            }
            const data = {
                BrandName: name,
                Country: $('fCountry').value.trim(),
                Description: $('fDesc').value.trim(),
                Status: $('fStatus').value
            };
            if (editingId) {
                Object.assign(brands.find(b => b.BrandID === editingId), data);
                toast('Brand updated')
            } else {
                brands.push({
                    BrandID: nextId++,
                    ...data,
                    CreatedAt: new Date().toISOString().slice(0, 10)
                });
                toast('Brand added')
            }
            $('form').close();
            render();
        }

        function askDelete(id) {
            const b = brands.find(x => x.BrandID === id),
                u = usage(id);
            deletingId = id;
            if (u.n) {
                $('confirmMsg').textContent = `${b.BrandName} is used by ${u.n} product(s), so it can't be deleted. Set it to Inactive instead.`;
                $('yesDel').hidden = true;
            } else {
                $('confirmMsg').textContent = `Delete ${b.BrandName}? This can't be undone.`;
                $('yesDel').hidden = false;
            }
            $('confirm').showModal();
        }

        $('addBtn').onclick = () => openForm();
        $('cancel').onclick = () => $('form').close();
        $('save').onclick = save;
        $('form').addEventListener('keydown', e => {
            if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
                e.preventDefault();
                save()
            }
        });
        $('noDel').onclick = () => $('confirm').close();
        $('yesDel').onclick = () => {
            brands = brands.filter(b => b.BrandID !== deletingId);
            $('confirm').close();
            render();
            toast('Brand deleted')
        };
        $('rows').onclick = e => {
            const t = e.target.closest('button');
            if (!t) return;
            if (t.dataset.edit) openForm(+t.dataset.edit);
            if (t.dataset.del) askDelete(+t.dataset.del);
        };
        $('q').oninput = renderTable;
        $('filter').onchange = renderTable;
        render();
    </script>
</body>

</html>