#running in google colab

#pip install Faker
#pip install python-dateutil

#after each code block excution, run below
#!ls -  run in Google Collab or whatever to list gererated files in the current directory
#from google.colab import files | files.download('test_publishers.csv') - run to down load the generated file/s in Google Collab

#the below generates 100rows of fake data in csv to populatetable users
from faker import Faker
from datetime import timedelta, datetime
from dateutil.relativedelta import relativedelta
import csv
import random

fake = Faker()

with open('test_users.csv', 'w', newline='') as csvfile:
    writer = csv.writer(csvfile)
    writer.writerow(['user_id', 'first_name', 'last_name', 'user_start_date', 'user_end_date', 'user_type', 'email', 'course_id', 'created_at', 'updated_at'])

    for i in range(1000, 1100):
        start_date = fake.date_between(start_date='-3y', end_date='today')
        end_date = start_date + relativedelta(years=3)

        created_at = fake.date_time_this_month()
        updated_at = fake.date_time_between_dates(
            datetime_start=created_at + timedelta(days=1),
            datetime_end=created_at + timedelta(days=60)
        )

        writer.writerow([
            i,
            fake.first_name(),
            fake.last_name(),
            start_date.strftime('%Y-%m-%d'),
            end_date.strftime('%Y-%m-%d'),
            fake.random_element(elements=('student', 'staff', 'guest', 'library')),
            fake.email(),
            fake.random_element(elements=('COURSE001', 'COURSE002', 'COURSE003')),
            created_at.strftime('%Y-%m-%d %H:%M:%S').strip(),
            updated_at.strftime('%Y-%m-%d %H:%M:%S').strip()
        ])

#the below generates 20rows of fake data in csv to populate table publishers
#pip install Faker  #pip install python-dateutil
from faker import Faker
from datetime import timedelta, datetime
from dateutil.relativedelta import relativedelta
import csv
import random

fake = Faker()

with open('test_publishers.csv', 'w', newline='') as csvfile:
    writer = csv.writer(csvfile, quoting=csv.QUOTE_ALL)
    writer.writerow(['publisher_id', 'publisher_name'])

    for i in range(100, 120):
        writer.writerow([
            i,
            fake.company()
        ])

#the below generates 1000rows of fake data in csv to fit table creators
#be wary of duplicate creator_id values, this is possible using Faker (there is probably a fix but have not found)
from faker import Faker
import csv
import random

fake = Faker()

with open('test_creators.csv', 'w', newline='') as csvfile:
    writer = csv.writer(csvfile, quoting=csv.QUOTE_ALL)
    writer.writerow(['creator_id', 'creator_name'])

    for _ in range(1000):
        name = fake.name()
        parts = name.split()
        if len(parts) >= 2:
            creator_id = parts[0][0].upper() + parts[-1][0].upper() + str(random.randint(1, 9999))
        else:
            creator_id = name[:2].upper() + str(random.randint(1, 9999))
        
        # Truncate creator_name to max 100 chars if needed
        creator_name = name[:100]

        writer.writerow([creator_id, creator_name])

#the below generates 4000rows of fake data in csv to fit table items
from faker import Faker
from datetime import timedelta
import csv
import random

fake = Faker()

with open('test_items.csv', 'w', newline='') as csvfile:
    writer = csv.writer(csvfile, quoting=csv.QUOTE_ALL)
    writer.writerow(['item_id', 'title', 'item_edition', 'isbn', 'item_type', 'publication_year', 'item_copy', 'publisher_id', 'category', 'item_status', 'created_at', 'updated_at'])

    for i in range(1, 4001):
        created_at = fake.date_time_this_month()
        updated_at = fake.date_time_between_dates(
            datetime_start=created_at + timedelta(days=1),
            datetime_end=created_at + timedelta(days=60)
        )

        writer.writerow([
            i,
            fake.sentence(nb_words=random.randint(3, 10)),
            random.randint(1, 9),
            fake.isbn13(separator='-'),
            fake.random_element(elements=('book', 'dvd', 'magazine', 'journal', 'programme')),
            random.randint(1901, 2023),
            random.randint(1, 6),
            random.randint(100, 119),
            fake.random_element(elements=('Play', 'Not-Play', 'Weapons', 'Costume design', 'Accent', 'Directing', 'Script writing')),
            'available',
            created_at.strftime('%Y-%m-%d %H:%M:%S').strip(),
            updated_at.strftime('%Y-%m-%d %H:%M:%S').strip()
        ])

#the below generates bewteen 4000 and 12000 rows of random data in csv to populate table item_creators using same creator_id and item_id as above
import csv
import random
# Ensure you have the test_creators.csv file generated from the previous step
# Ensure you have the test_items.csv file generated from the previous step

# Step 1: Load creator_ids
creator_ids = []
with open('test_creators.csv', 'r') as csvfile:
    reader = csv.DictReader(csvfile)
    for row in reader:
        creator_ids.append(row['creator_id'])

# Step 2: Create item_creators.csv
with open('test_item_creators.csv', 'w', newline='') as outfile:
    writer = csv.writer(outfile)
    writer.writerow(['item_id', 'creator_id'])

    for item_id in range(1, 4001):
        num_creators = random.randint(1, 3)
        selected_creators = random.sample(creator_ids, num_creators)
        for creator_id in selected_creators:
            writer.writerow([item_id, creator_id])

#the below generates 1000rows of random data in csv to fit table circulation(REDUNDANT USE NEXT CODE BLOCK)
from faker import Faker
import csv
import random
from datetime import datetime, timedelta

fake = Faker()

# Step 1: Load item_ids
item_ids = []
with open('test_items.csv', 'r') as csvfile:
    reader = csv.DictReader(csvfile)
    for row in reader:
        item_ids.append(row['item_id'])
# Step 2: Load user_ids
user_ids = []
with open('test_users.csv', 'r') as csvfile:
    reader = csv.DictReader(csvfile)
    for row in reader:
        user_ids.append(row['user_id'])
# Step 3: Create circulation.csv
with open('test_circulation.csv', 'w', newline='') as outfile:
    writer = csv.writer(outfile)
    writer.writerow(['circulation_id', 'user_id', 'item_id', 'borrow_date', 'date_due_back', 'returned_date', 'next_reminder_date', 'item_circulation_status', 'created_at', 'updated_at'])

    for circulation_id in range(1, 1001):
        user_id = random.choice(user_ids)
        item_id = random.choice(item_ids)
        borrow_date = fake.date_between(start_date='-1y', end_date='today')
        returned_date = None if random.random() < 0.7 else borrow_date + timedelta(days=random.randint(1, 60))
        next_reminder_date = borrow_date + timedelta(days=23)
        item_circulation_status = 'returned' if returned_date else 'borrowed'
        if returned_date and returned_date > borrow_date + timedelta(days=30):
            item_circulation_status = 'overdue'
        created_at = fake.date_time_this_month()
        updated_at = fake.date_time_between_dates(
            datetime_start=created_at + timedelta(days=1),
            datetime_end=created_at + timedelta(days=60)
        )
        writer.writerow([
            circulation_id,
            user_id,
            item_id,
            borrow_date.strftime('%Y-%m-%d'),
            (borrow_date + timedelta(days=30)).strftime('%Y-%m-%d'),
            returned_date.strftime('%Y-%m-%d') if returned_date else None,
            next_reminder_date.strftime('%Y-%m-%d'),
            item_circulation_status,
            created_at.strftime('%Y-%m-%d %H:%M:%S').strip(),
            updated_at.strftime('%Y-%m-%d %H:%M:%S').strip()
        ])

#the below generates 60rows of random data in csv to populate table circulation (diff from above is that returned_date = returned regardless of if late or not)
#edit: changed again to all rows created today, all borrowed to create a more workable dataset for testing

from faker import Faker
import csv
import random
from datetime import datetime, timedelta

fake = Faker()

# Step 1: Load item_ids
item_ids = []
with open('test_items.csv', 'r') as csvfile:
    reader = csv.DictReader(csvfile)
    for row in reader:
        item_ids.append(row['item_id'])

# Step 2: Load user_ids
user_ids = []
with open('test_users.csv', 'r') as csvfile:
    reader = csv.DictReader(csvfile)
    for row in reader:
        user_ids.append(row['user_id'])

# Step 3: Create circulation.csv
with open('test_circulation.csv', 'w', newline='') as outfile:
    writer = csv.writer(outfile)
    writer.writerow([
        'circulation_id', 'user_id', 'item_id', 'borrow_date', 'date_due_back',
        'returned_date', 'next_reminder_date', 'item_circulation_status',
        'created_at', 'updated_at'
    ])

    today = datetime.today().date()
    for circulation_id in range(1, 61):
        user_id = random.choice(user_ids)
        item_id = random.choice(item_ids)
        borrow_date = today
        returned_date.strftime('%Y-%m-%d') if returned_date else None
        next_reminder_date = borrow_date + timedelta(days=23)
        item_circulation_status = 'borrowed'
        created_at = datetime.today()
        updated_at = datetime.today()

        writer.writerow([
            circulation_id,
            user_id,
            item_id,
            borrow_date.strftime('%Y-%m-%d'),
            (borrow_date + timedelta(days=30)).strftime('%Y-%m-%d'),
            returned_date,
            next_reminder_date.strftime('%Y-%m-%d'),
            item_circulation_status,
            created_at.strftime('%Y-%m-%d %H:%M:%S'),
            updated_at.strftime('%Y-%m-%d %H:%M:%S')
        ])
