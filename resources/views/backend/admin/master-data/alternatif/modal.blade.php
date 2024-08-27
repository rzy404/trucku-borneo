<!-- view modal -->
<div class="modal fade" id="ModalKriteria">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Standar Penilaian Kriteria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 row">
                    <div class="col-6">
                        <h5>Kriteria Jarak Tempuh</h5>
                        <div class="table-responsive">
                            <table class="table primary-table-bordered">
                                <thead class="thead-primary">
                                    <tr>
                                        <th>Range</th>
                                        <th>Bobot</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>x < 30 km</td>
                                        <td>4</td>
                                    </tr>
                                    <tr>
                                        <td>30 km <= 50 km</td>
                                        <td>5</td>
                                    </tr>
                                    <tr>
                                        <td>50 km > x</td>
                                        <td>5</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-6">
                        <h5>Kriteria Jumlah Muatan</h5>
                        <div class="table-responsive">
                            <table class="table primary-table-bordered">
                                <thead class="thead-primary">
                                    <tr>
                                        <th>Range</th>
                                        <th>Bobot</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>x < 125 Ton</td>
                                        <td>5</td>
                                    </tr>
                                    <tr>
                                        <td>125 Ton <= 900 Ton</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>900 Ton > x</td>
                                        <td>2</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12 row">
                    <div class="col-6">
                        <h5>Kriteria Biaya Sewa</h5>
                        <div class="table-responsive">
                            <table class="table primary-table-bordered">
                                <thead class="thead-primary">
                                    <tr>
                                        <th>Range</th>
                                        <th>Bobot</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>x < Rp 50,000,000</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>Rp 50,000,000 <= Rp 150,000,000</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>Rp 150,000,000 > x</td>
                                        <td>5</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-6">
                        <h5>Kriteria Lama Sewa</h5>
                        <div class="table-responsive">
                            <table class="table primary-table-bordered">
                                <thead class="thead-primary">
                                    <tr>
                                        <th>Range</th>
                                        <th>Bobot</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>x < 15 Hari</td>
                                        <td>5</td>
                                    </tr>
                                    <tr>
                                        <td>15 Hari <= 42 Hari</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>42 Hari > x</td>
                                        <td>1</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>