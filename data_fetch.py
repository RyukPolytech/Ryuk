import csv
import os

import requests
from tqdm import tqdm

url = "https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/liste-des-personnes-decedees-en-france/exports/csv?lang=en&timezone=Europe%2FBerlin&use_labels=true&delimiter=%3B"

output_dir = "assets/dataFiles/deathlist"
os.makedirs(output_dir, exist_ok=True)

print("[Data Fetch] Downloading death list data...")
response = requests.get(url, stream=True)
response.raise_for_status()


total_size = 5 * 1024 * 1024 * 1024
block_size = 1024
tqdm_bar = tqdm(total=total_size, unit="iB", unit_scale=True)

chunk_size = 2000000
env_file_path = ".env"
header = None
chunk = []
file_index = 1


def update_env_file():
    with open(env_file_path) as f:
        lines = f.readlines()
    with open(env_file_path, "w") as f:
        found = False
        for line in lines:
            if line.startswith("COUNT_DEATH_LIST_FILE="):
                f.write(f"COUNT_DEATH_LIST_FILE={file_index}\n")
                found = True
                break
            f.write(line)
        if not found:
            f.write(f"COUNT_DEATH_LIST_FILE={file_index}\n")


for data in response.iter_content(block_size):
    tqdm_bar.update(len(data))
    lines = data.decode("utf-8", errors="replace").splitlines()
    for line in lines:
        if header is None:
            header = line.split(";")
        else:
            chunk.append(line.split(";"))
            if len(chunk) == chunk_size:
                output_file = os.path.join(
                    output_dir, f"deathlist_part_{file_index}.csv"
                )
                print(
                    f"\r[Data Fetch] Writing file deathlist_part_{file_index}.csv in {output_dir}"
                )
                with open(output_file, "w", newline="") as f:
                    writer = csv.writer(f, delimiter=";")
                    writer.writerow(header)
                    writer.writerows(chunk)
                update_env_file()
                chunk = []
                file_index += 1

if chunk:
    output_file = os.path.join(output_dir, f"deathlist_part_{file_index}.csv")
    print(
        f"\r[Data Fetch] Writing file deathlist_part_{file_index}.csv in {output_dir}"
    )
    with open(output_file, "w", newline="") as f:
        writer = csv.writer(f, delimiter=";")
        writer.writerow(header)
        writer.writerows(chunk)

tqdm_bar.close()
print("[Data Fetch] Finished process, Have a nice death!")
