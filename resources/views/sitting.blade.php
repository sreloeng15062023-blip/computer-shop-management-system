<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Settings</title>
    <style>
        :root {
            --ink: #1c2430;
            --mut: #6b7686;
            --line: #e4e8ee;
            --acc: #1f5eff;
            --soft: #f5f7fa;
            box-sizing: border-box;
            padding-top: env(safe-area-inset-top, 0px);
            padding-bottom: env(safe-area-inset-bottom, 0px);
            color-scheme: light
        }

        html {
            scroll-padding-top: env(safe-area-inset-top, 0px)
        }

        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            background: #fff;
            color: var(--ink);
            font: 15px/1.5 "Inter", "Segoe UI", system-ui, sans-serif
        }

        .app {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh
        }

        nav {
            border-right: 1px solid var(--line);
            padding: 24px 14px;
            position: sticky;
            top: 0;
            height: 100vh;
            background: #fff
        }

        nav h1 {
            font-size: 18px;
            margin: 0 10px 18px
        }

        nav button {
            display: flex;
            gap: 10px;
            align-items: center;
            width: 100%;
            text-align: left;
            border: 0;
            background: none;
            padding: 10px 12px;
            border-radius: 8px;
            font: inherit;
            color: var(--mut);
            cursor: pointer
        }

        nav button:hover {
            background: var(--soft)
        }

        nav button.on {
            background: #eaf0ff;
            color: var(--acc);
            font-weight: 600
        }

        main {
            padding: 32px;
            max-width: 860px;
            width: 100%
        }

        h2 {
            margin: 0 0 4px;
            font-size: 22px
        }

        .sub {
            color: var(--mut);
            margin: 0 0 24px
        }

        .panel {
            display: none
        }

        .panel.on {
            display: block
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 12px;
            margin-bottom: 24px
        }

        .stat {
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 14px
        }

        .stat small {
            color: var(--mut)
        }

        .stat b {
            display: block;
            font-size: 20px;
            margin-top: 2px
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px
        }

        label {
            display: block;
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 5px
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--line);
            border-radius: 8px;
            font: inherit;
            background: #fff;
            color: var(--ink)
        }

        input:focus,
        select:focus,
        textarea:focus,
        button:focus-visible {
            outline: 2px solid var(--acc);
            outline-offset: 1px
        }

        input[type=checkbox] {
            width: 18px;
            height: 18px;
            accent-color: var(--acc)
        }

        .full {
            grid-column: 1/-1
        }

        .btn {
            background: var(--acc);
            color: #fff;
            border: 0;
            padding: 10px 18px;
            border-radius: 8px;
            font: inherit;
            font-weight: 600;
            cursor: pointer
        }

        .btn.alt {
            background: #fff;
            color: var(--ink);
            border: 1px solid var(--line)
        }

        .btn.bad {
            background: #c62828
        }

        .row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 20px
        }

        table {
            width: 100%;
            border-collapse: collapse
        }

        th,
        td {
            text-align: left;
            padding: 10px 8px;
            border-bottom: 1px solid var(--line)
        }

        th {
            font-size: 13px;
            color: var(--mut)
        }

        .wrap {
            overflow-x: auto
        }

        .sw {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 400;
            margin: 0
        }

        .note {
            background: var(--soft);
            border-radius: 8px;
            padding: 12px 14px;
            color: var(--mut);
            margin-top: 16px
        }

        .prev {
            border: 1px dashed var(--line);
            border-radius: 10px;
            padding: 14px;
            margin-top: 16px
        }

        #toast {
            position: fixed;
            left: 50%;
            bottom: calc(20px + env(safe-area-inset-bottom, 0px));
            transform: translateX(-50%);
            background: var(--ink);
            color: #fff;
            padding: 10px 18px;
            border-radius: 8px;
            opacity: 0;
            pointer-events: none;
            transition: opacity .2s
        }

        #toast.show {
            opacity: 1
        }

        @media(max-width:760px) {
            .app {
                grid-template-columns: 1fr
            }

            nav {
                position: static;
                height: auto;
                display: flex;
                overflow-x: auto;
                gap: 4px;
                padding: 10px;
                border-right: 0;
                border-bottom: 1px solid var(--line)
            }

            nav h1 {
                display: none
            }

            nav button {
                white-space: nowrap;
                width: auto
            }

            main {
                padding: 20px 16px
            }

            .grid {
                grid-template-columns: 1fr
            }
        }
    </style>
</head>

<body>
    <div class="app">
        <nav id="nav" aria-label="Settings">
            <h1>Settings</h1>
            <button data-p="shop" class="on">🏪 Shop Information</button>
            <button data-p="tax">🧾 Tax Configuration</button>
            <button data-p="cur">💱 Currency Settings</button>
            <button data-p="hours">🕒 Business Hours</button>
            <button data-p="bak">💾 Backup Database</button>
            <button data-p="res">♻️ Restore Database</button>
        </nav>
        <main>

            <section class="panel on" id="shop">
                <h2>Shop Information</h2>
                <p class="sub">Details shown on receipts and invoices.</p>
                <div class="grid">
                    <div><label for="sn">Shop name</label><input id="sn" placeholder="e.g. My Shop"></div>
                    <div><label for="sp">Phone</label><input id="sp" type="tel" placeholder="+855 ..."></div>
                    <div><label for="se">Email</label><input id="se" type="email"></div>
                    <div><label for="sv">VAT / Tax ID</label><input id="sv"></div>
                    <div class="full"><label for="sa">Address</label><textarea id="sa" rows="3"></textarea></div>
                    <div class="full"><label for="sf">Receipt footer</label><input id="sf" value="Thank you for shopping with us!"></div>
                </div>
                <div class="row"><button class="btn" data-save="Shop information saved">Save changes</button><button class="btn alt" data-reset>Reset</button></div>
            </section>

            <section class="panel" id="tax">
                <h2>Tax Configuration</h2>
                <p class="sub">Set how tax is applied to sales.</p>
                <div class="grid">
                    <div><label for="tn">Tax name</label><input id="tn" value="VAT"></div>
                    <div><label for="tr">Tax rate (%)</label><input id="tr" type="number" min="0" max="100" step="0.01" value="10"></div>
                    <div><label for="tm">Price mode</label><select id="tm">
                            <option value="ex">Prices exclude tax</option>
                            <option value="in">Prices include tax</option>
                        </select></div>
                    <div><label>Apply tax</label><label class="sw"><input type="checkbox" id="ton" checked> Enabled</label></div>
                </div>
                <div class="prev"><b>Preview</b>
                    <div class="grid" style="margin-top:8px">
                        <div><label for="tp">Sample price</label><input id="tp" type="number" value="100" min="0" step="0.01"></div>
                        <div id="tout"></div>
                    </div>
                </div>
                <div class="row"><button class="btn" data-save="Tax settings saved">Save changes</button></div>
            </section>

            <section class="panel" id="cur">
                <h2>Currency Settings</h2>
                <p class="sub">Choose how amounts are shown across the system.</p>
                <div class="grid">
                    <div><label for="cc">Main currency</label><select id="cc">
                            <option value="USD|$">USD ($)</option>
                            <option value="KHR|៛">KHR (៛)</option>
                            <option value="THB|฿">THB (฿)</option>
                            <option value="EUR|€">EUR (€)</option>
                        </select></div>
                    <div><label for="cp">Symbol position</label><select id="cp">
                            <option value="b">Before amount ($1,000.00)</option>
                            <option value="a">After amount (1,000.00$)</option>
                        </select></div>
                    <div><label for="cd">Decimal places</label><select id="cd">
                            <option>0</option>
                            <option selected>2</option>
                            <option>3</option>
                        </select></div>
                    <div><label for="cr">Exchange rate (1 USD = KHR)</label><input id="cr" type="number" value="4100" min="0"></div>
                </div>
                <div class="prev"><b>Preview</b>
                    <div id="cout" style="font-size:22px;margin-top:6px"></div>
                </div>
                <div class="row"><button class="btn" data-save="Currency settings saved">Save changes</button></div>
            </section>

            <section class="panel" id="hours">
                <h2>Business Hours</h2>
                <p class="sub">Opening and closing time for each day.</p>
                <div class="wrap">
                    <table id="ht">
                        <thead>
                            <tr>
                                <th>Day</th>
                                <th>Open</th>
                                <th>Close</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="row"><button class="btn" data-save="Business hours saved">Save changes</button><button class="btn alt" id="copyH">Copy Monday to all</button></div>
            </section>

            <section class="panel" id="bak">
                <h2>Backup Database</h2>
                <p class="sub">Create a snapshot of your shop data.</p>
                <div class="stats">
                    <div class="stat"><small>Last backup</small><b id="lb">Never</b></div>
                    <div class="stat"><small>Total backups</small><b id="tb">0</b></div>
                </div>
                <div class="grid">
                    <div><label for="bn">Backup name (optional)</label><input id="bn" placeholder="e.g. End of month"></div>
                    <div><label for="bt">Include</label><select id="bt">
                            <option>All data</option>
                            <option>Sales only</option>
                            <option>Products only</option>
                        </select></div>
                </div>
                <div class="row"><button class="btn" id="mk">Create backup</button></div>
                <div class="wrap" style="margin-top:20px">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="bl"></tbody>
                    </table>
                </div>
            </section>

            <section class="panel" id="res">
                <h2>Restore Database</h2>
                <p class="sub">Replace current data with a saved backup.</p>
                <div class="grid">
                    <div><label for="rs">Choose backup</label><select id="rs"></select></div>
                    <div><label for="rf">Or upload a backup file</label><input id="rf" type="file"></div>
                </div>
                <div class="note">⚠️ Restoring replaces all current data. Create a new backup first if you may need it.</div>
                <div class="row"><button class="btn bad" id="rr">Restore selected backup</button></div>
            </section>
        </main>
    </div>
    <div id="toast" role="status"></div>

    <script>
        const $ = s => document.querySelector(s),
            $$ = s => [...document.querySelectorAll(s)];

        function toast(m) {
            const t = $('#toast');
            t.textContent = m;
            t.classList.add('show');
            clearTimeout(t._h);
            t._h = setTimeout(() => t.classList.remove('show'), 2200)
        }
        $$('#nav button').forEach(b => b.onclick = () => {
            $$('#nav button,.panel').forEach(e => e.classList.remove('on'));
            b.classList.add('on');
            $('#' + b.dataset.p).classList.add('on');
            scrollTo(0, 0)
        });
        $$('[data-save]').forEach(b => b.onclick = () => toast(b.dataset.save));
        $$('[data-reset]').forEach(b => b.onclick = () => {
            $$('#shop input,#shop textarea').forEach(i => i.value = '');
            toast('Form cleared')
        });

        function money(n, sym, pos, d) {
            const s = n.toLocaleString('en-US', {
                minimumFractionDigits: d,
                maximumFractionDigits: d
            });
            return pos === 'b' ? sym + s : s + sym
        }

        function calc() {
            const [code, sym] = $('#cc').value.split('|'), pos = $('#cp').value, d = +$('#cd').value, rate = +$('#cr').value || 0;
            $('#cout').innerHTML = money(1234.5, sym, pos, d) + ` <small style="color:var(--mut);font-size:14px">${code} · $1 = ${rate.toLocaleString('en-US')} ៛</small>`;
            const r = +$('#tr').value || 0,
                p = +$('#tp').value || 0,
                on = $('#ton').checked,
                inc = $('#tm').value === 'in',
                f = n => money(n, sym, pos, d);
            let base = p,
                tax = 0;
            if (on) {
                if (inc) {
                    base = p / (1 + r / 100);
                    tax = p - base
                } else tax = p * r / 100
            }
            $('#tout').innerHTML = `Subtotal: <b>${f(base)}</b><br>${$('#tn').value||'Tax'} (${r}%): <b>${f(tax)}</b><br>Total: <b>${f(base+tax)}</b>`
        }
        ['tn', 'tr', 'tm', 'tp', 'ton', 'cc', 'cp', 'cd', 'cr'].forEach(i => $('#' + i).addEventListener('input', calc));
        calc();
        const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $('#ht tbody').innerHTML = days.map(d => `<tr><td>${d}</td><td><input type="time" value="08:00"></td><td><input type="time" value="20:00"></td><td><label class="sw"><input type="checkbox" checked><span>Open</span></label></td></tr>`).join('');
        $$('#ht tbody input[type=checkbox]').forEach(c => c.onchange = () => {
            c.nextElementSibling.textContent = c.checked ? 'Open' : 'Closed';
            c.closest('tr').querySelectorAll('input[type=time]').forEach(t => t.disabled = !c.checked)
        });
        $('#copyH').onclick = () => {
            const r = $$('#ht tbody tr'),
                [o, c] = r[0].querySelectorAll('input[type=time]');
            r.forEach(x => {
                const t = x.querySelectorAll('input[type=time]');
                t[0].value = o.value;
                t[1].value = c.value
            });
            toast('Monday hours copied to all days')
        };
        let backups = [];

        function renderB() {
            $('#bl').innerHTML = backups.length ? backups.map((b, i) => `<tr><td>${b.n}</td><td>${b.d}</td><td>${b.t}</td><td><button class="btn alt" data-del="${i}">Delete</button></td></tr>`).join('') : '<tr><td colspan="4" style="color:var(--mut)">No backups yet. Create your first backup above.</td></tr>';
            $('#rs').innerHTML = backups.length ? backups.map((b, i) => `<option value="${i}">${b.n} — ${b.d}</option>`).join('') : '<option value="">No backups available</option>';
            $('#lb').textContent = backups.length ? backups[0].d : 'Never';
            $('#tb').textContent = backups.length;
            $$('[data-del]').forEach(x => x.onclick = () => {
                backups.splice(+x.dataset.del, 1);
                renderB();
                toast('Backup deleted')
            })
        }
        $('#mk').onclick = () => {
            const d = new Date().toLocaleString('en-US', {
                dateStyle: 'medium',
                timeStyle: 'short'
            });
            const n = ($('#bn').value.trim() || 'Backup ' + (backups.length + 1)).replace(/[<>&]/g, '');
            backups.unshift({
                n,
                d,
                t: $('#bt').value
            });
            $('#bn').value = '';
            renderB();
            toast('Backup created')
        };
        $('#rr').onclick = () => {
            if (!backups.length && !$('#rf').files.length) return toast('Select a backup first');
            if (confirm('Restore this backup? Current data will be replaced.')) toast('Database restored')
        };
        renderB();
    </script>
</body>

</html>