/*
 * Copyright [2017] Illia Voinov <ilya.voinov@yahoo.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

RegionUpdater.prototype.bindCityUpdate = function (regionSelectElement, citySearchUrl) {
    function updateCity(e) {
        new Ajax.Request(citySearchUrl, {
            method: 'GET',
            parameters: {'area_id': e.target.options[e.target.selectedIndex].value},
            onSuccess: function (transport) {
                var response = transport.responseJSON;
                if (response.hasOwnProperty('totalRecords') && response.totalRecords > 0) {
                    response.items;
                }
            }
        });
    }

    Event.observe($(regionSelectElement), 'change', updateCity.bind(this));
};
