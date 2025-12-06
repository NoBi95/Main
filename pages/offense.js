"use client";

import { useEffect, useState } from "react";

export default function OffensePage() {
  const [vehicles, setVehicles] = useState([]);
  const [penalties, setPenalties] = useState([]);
  const [selectedVehicle, setSelectedVehicle] = useState("");
  const [selectedPenalty, setSelectedPenalty] = useState("");
  const [message, setMessage] = useState("");
  const [loading, setLoading] = useState(false);

  // Load vehicles and penalties
  useEffect(() => {
    async function fetchData() {
      try {
        const resVehicles = await fetch("/api/offense/vehicles");
        const vehiclesData = await resVehicles.json();
        setVehicles(vehiclesData);

        const resPenalties = await fetch("/api/offense/penalties");
        const penaltiesData = await resPenalties.json();
        setPenalties(penaltiesData);
      } catch (err) {
        console.error(err);
      }
    }
    fetchData();
  }, []);

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (!selectedVehicle || !selectedPenalty) return setMessage("Select vehicle and penalty");

    setLoading(true);
    setMessage("");

    try {
      const res = await fetch("/api/offense/create", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ vehicleID: selectedVehicle, penaltyID: selectedPenalty }),
      });
      const data = await res.json();
      setMessage(data.success ? `✅ ${data.message}` : `⚠️ ${data.message}`);
    } catch (err) {
      console.error(err);
      setMessage("❌ Server error");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div style={{ maxWidth: "500px", margin: "20px auto", padding: "20px", border: "1px solid #ccc", borderRadius: "8px" }}>
      <h1>Log Vehicle Offense</h1>
      <form onSubmit={handleSubmit}>
        <label>
          Select Vehicle:
          <select value={selectedVehicle} onChange={(e) => setSelectedVehicle(e.target.value)} required>
            <option value="">--Select Vehicle--</option>
            {vehicles.map((v) => (
              <option key={v.VehicleID} value={v.VehicleID}>
                {v.UserName || "Visitor"} - {v.PlateNumber || v.DriverName} ({v.VehicleType})
              </option>
            ))}
          </select>
        </label>

        <br />
        <label>
          Select Penalty:
          <select value={selectedPenalty} onChange={(e) => setSelectedPenalty(e.target.value)} required>
            <option value="">--Select Penalty--</option>
            {penalties.map((p) => (
              <option key={p.PenaltyID} value={p.PenaltyID}>
                {p.PenaltyType} - ${p.Amount}
              </option>
            ))}
          </select>
        </label>

        <br />
        <button type="submit" disabled={loading} style={{ marginTop: "10px" }}>
          {loading ? "Logging..." : "Log Offense"}
        </button>
      </form>

      {message && <p style={{ marginTop: "10px" }}>{message}</p>}
    </div>
  );
}
